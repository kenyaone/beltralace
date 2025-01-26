<?php 
    include_once 'Settings.php';

    class SMS {
        public $api_url = 'https://sms.textsms.co.ke/api/services/';
        public $partnerID = null;
        public $apikey = null;
        public $shortCode = null;
        public $mobile = null;
        public $contact = null;
        public $message = null;
        public $timeToSend = null;
        public $placeholder = null;
        public $salutation = null;
        public $first_name = null;
        public $surname = null;
        public $sent_message = array();
        public $message_id = null;
        public $delivery_report = null;

        public $settings = null;
        public $send_sms = 0;

        /* Datatable */

        public $draw = null;
        public $columns = null;
        public $start = 0;
        public $length = null;
        public $search = null;
        public $order = null;

        public function __construct ($data = array()) {
            if (isset($data['api_url']) && !empty($data['api_url'])) {
                $this->api_url = $data['api_url'];
            }
            if (isset($data['partnerID']) && !empty($data['partnerID'])) {
                $this->partnerID = $data['partnerID'];
            }
            if (isset($data['apikey']) && !empty($data['apikey'])) {
                $this->apikey = $data['apikey'];
            }
            if (isset($data['shortCode']) && !empty($data['shortCode'])) {
                $this->shortCode = $data['shortCode'];
            }
            if (isset($data['mobile']) && !empty($data['mobile'])) {
                $this->mobile = $data['mobile'];
            }
            if (isset($data['contact']) && !empty($data['contact'])) {
                $this->contact = $data['contact'];
            }
            if (isset($data['message']) && !empty($data['message'])) {
                $this->message = $data['message'];
            }
            if (isset($data['timeToSend']) && !empty($data['timeToSend'])) {
                $this->timeToSend = $data['timeToSend'];
            }
            if (isset($data['placeholder']) && !empty($data['placeholder'])) {
                $this->placeholder = $data['placeholder'];
            }
            if (isset($data['salutation']) && !empty($data['salutation'])) {
                $this->salutation = $data['salutation'];
            }
            if (isset($data['first_name']) && !empty($data['first_name'])) {
                $this->first_name = $data['first_name'];
            }
            if (isset($data['surname']) && !empty($data['surname'])) {
                $this->surname = $data['surname'];
            }
            if (isset($data['message_id']) && !empty($data['message_id'])) {
                $this->message_id = $data['message_id'];
            }

            /* Datatable */

            if (isset($data['draw']) && !empty($data['draw'])) {
                $this->draw = $data['draw'];
            }
            if (isset($data['columns']) && !empty($data['columns'])) {
                $this->columns = $data['columns'];
            }
            if (isset($data['start']) && !empty($data['start'])) {
                $this->start = $data['start'];
            }
            if (isset($data['length']) && !empty($data['length'])) {
                $this->length = $data['length'];
            }
            if (isset($data['search']) && !empty($data['search'])) {
                $this->search = $data['search'];
            }
            if (isset($data['order']) && !empty($data['order'])) {
                $this->order = $data['order'];
            }
        }

        public function initializeParams ($params) {
            $this->__construct($params);
            if (!is_null($this->timeToSend)) {
                $timeToSend = new DateTime($this->timeToSend);
                $this->timeToSend = $timeToSend->format('Y-m-d H:i');   
            }
            $this->settings = Settings::get_configs();
            if ($this->settings) {
                $this->send_sms = $this->settings->send_sms;
                $this->partnerID = $this->settings->sms_partner_id;
                $this->apikey = $this->settings->sms_apikey;
                $this->shortCode = $this->settings->sms_shortCode;
            }
        }

        public function send () {
            if ($this->send_sms) {
                $pattern = "/\%[\w]+\%/";
                $placeholder = preg_match_all($pattern, $this->message, $array);
                $this->placeholder = $placeholder;

                if ($this->contact) {
                    $this->contacts = $this->getContacts();   
                }
                if ($this->placeholder) {
                    $this->api_url = $this->api_url.'sendbulk/';
                    $message_list = array();
                    $success = false;
                    $sent_count = 0;
                    if ($this->contacts) {
                        foreach ($this->contacts as $contact) {
                            $message = $this->message;
                            $message = str_replace("%first_name%", $contact->first_name, $message);
                            $message = str_replace("%surname%", $contact->surname, $message);
                            if (!is_null($contact->salutation) && !empty($contact->salutation)) {
                                $message = str_replace("%salutation%", $contact->salutation, $message);
                            }
                            else {
                                $message = str_replace("%salutation%", '', $message);
                            }
                            $mobile_message = array(
                                'message' => $message,
                                'mobile' => $contact->phone
                            );
                            $message_list[] = $mobile_message;
                        }   
                    }
                    $message_list = array_chunk($message_list, 20);
                    foreach ($message_list as $key => $chunk) {
                        $sms_list = array();
                        foreach ($chunk as $message) {
                            $sms = array(
                                'partnerID' => $this->partnerID,
                                'apikey' => $this->apikey,
                                'clientsmsid' => rand(1, 1000),
                                'mobile' => $message['mobile'],
                                'message' => $message['message'],
                                'shortcode' => $this->shortCode,
                                'pass_type' => 'plain'
                            );
                            if (!is_null($this->timeToSend)) {
                                $sms['timeToSend'] = $this->timeToSend;
                            }
                            $sms_list[] = $sms;
                        }
                        $post_data = array(
                            "count" => count($sms_list),
                            "smslist" => $sms_list
                        );
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $this->api_url);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
                        $response = curl_exec($ch);
                        if (!curl_errno($ch)) {
                            $data = json_decode($response);
                            foreach ($data->responses as $value) {
                                if (isset($value->{"response-code"}) && $value->{"response-code"} == 200) {
                                    $sent_count++;
                                    $success = true;
                                }
                                else {
                                    if (isset($value->{"respose-code"}) && $value->{"respose-code"} == 200) {
                                        $sent_count++;
                                        $success = true;
                                    } 
                                }
                                $this->sent_message[] = array(
                                    'message_id' => $value->messageid,
                                    'mobile' => Functions::intlPhone($value->mobile, 'KE'),
                                    'message' => '',
                                    'network' => $value->networkid
                                );
                            }
                            foreach ($this->sent_message as &$item) {
                                foreach ($sms_list as $sms) {
                                    if ($item['mobile'] === $sms['mobile']) {
                                        $item['message'] = $sms['message'];
                                    }
                                }
                            }
                        }
                    }
    
                    if ($success) {
                        $feedback_message = '<p>Message sent successfully to '.$sent_count.' of '.count($this->contacts).' contacts</p>';
                        echo json_encode(array(
                            'status' => 1,
                            'title' => '<span class="text-success"><i class="fa fa-check"></i> Success!</span>',
                            'message' => $feedback_message
                        )); 
                    }
                    else {
                        echo json_encode(array(
                            'status' => 0,
                            'title' => '<span class="text-danger"><span class="fa fa-warning"></span> Error!</span>',
                            'message' => curl_error($ch)
                        ));
                    }
                }
                else {
                    $this->api_url = $this->api_url.'sendsms/';   
                    if (!is_null($this->mobile) && !is_array($this->mobile)) {
                        $mobile = $this->mobile;
                    }
                    else {
                        $mobile = '';
                        foreach ($this->contacts as $key => $contact) {
                            if ($key != (count($this->contacts) - 1)) {
                                $mobile .= $contact->phone.',';
                            }
                            else {
                                $mobile .= $contact->phone;
                            }
                        }
                    }
                    $post_data = array(
                        'partnerID' => $this->partnerID,
                        'apikey' => $this->apikey,
                        'mobile' => $mobile,
                        'message' => $this->message,
                        'shortcode' => $this->shortCode,
                        'pass_type' => 'plain'
                    );
                    if (!is_null($this->timeToSend)) {
                        $post_data['timeToSend'] = $this->timeToSend;
                    }
    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $this->api_url);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
                    $response = curl_exec($ch);
                    if (!curl_errno($ch)) {
                        $data = json_decode($response);
                        /* echo json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_SLASHES);
                        exit; */
                        if (!is_null($this->mobile) && !is_array($this->mobile)) {
                            $feedback_message = '<p>Message sent successfully to '.$this->mobile.'</p>';
                            $title = '<span class="text-success"><i class="fa fa-check"></i> Success!</span>';
                            $status = 1;
                            foreach ($data->responses as $value) {
                                if ($value->{"response-code"} !== 200) {
                                    $feedback_message = '<p>' .$value->{"response-description"}. '</p>';
                                    $title = '<span class="text-danger"><i class="fa fa-check"></i> Error!</span>';
                                    $status = 0;
                                }
                                else {
                                    $feedback_message = '<p>Message sent successfully to '.$value->mobile.'</p>';
                                }
                                $this->sent_message[] = array(
                                    'message_id' => $value->messageid,
                                    'mobile' => Functions::intlPhone($value->mobile, 'KE'),
                                    'message' => $this->message,
                                    'network' => $value->networkid
                                );
                            }
                        } 
                        else {
                            $title = '<span class="text-success"><i class="fa fa-check"></i> Success!</span>';
                            $status = 1;
                            $sent_count = 0;
                            foreach ($data->responses as $value) {
                                if (isset($value->{"response-code"}) && $value->{"response-code"} == 200) {
                                    $sent_count++;
                                }
                                else {
                                    if (isset($value->{"respose-code"}) && $value->{"respose-code"} == 200) {
                                        $sent_count++;
                                    } 
                                }
                                $this->sent_message[] = array(
                                    'message_id' => $value->messageid,
                                    'mobile' => Functions::intlPhone($value->mobile, 'KE'),
                                    'message' => $this->message,
                                    'network' => $value->networkid
                                );
                            }
                            $feedback_message = '<p>Message sent successfully to '.$sent_count.' of '.count($this->contact).' contacts</p>';
                        }
                        echo json_encode(array(
                            'status' => $status,
                            'title' => $title,
                            'message' => $feedback_message
                        )); 
                    }
                    else {
                        echo json_encode(array(
                            'status' => 0,
                            'title' => '<span class="text-danger"><span class="fa fa-warning"></span> Error!</span>',
                            'message' => curl_error($ch)
                        ));
                    }
                }
                $this->saveMessage();   
            }
            else {
                echo json_encode(array(
                    'status' => 0,
                    'title' => '<span class="text-primary"><span class="fa fa-warning"></span> Info!</span>',
                    'message' => 'SMS sending not allowed.'
                ), JSON_PRETTY_PRINT+JSON_UNESCAPED_SLASHES);
            }
        }

        public function sendBulk () {
            if ($this->send_sms) {
                $this->api_url = $this->api_url.'sendbulk/';
                $message_list = array();
                $success = false;
                $sent_count = 0;
                if (is_array($this->mobile)) {
                    for ($i=0; $i < count($this->mobile); $i++) { 
                        $mobile_message = array(
                            'message' => $this->message[$i],
                            'mobile' => $this->mobile[$i]
                        );
                        $message_list[] = $mobile_message;
                    }  
                }
                $message_list = array_chunk($message_list, 20);
                foreach ($message_list as $key => $chunk) {
                    $sms_list = array();
                    foreach ($chunk as $message) {
                        $sms = array(
                            'partnerID' => $this->partnerID,
                            'apikey' => $this->apikey,
                            'clientsmsid' => rand(1, 1000000),
                            'mobile' => $message['mobile'],
                            'message' => $message['message'],
                            'shortcode' => $this->shortCode,
                            'pass_type' => 'plain'
                        );
                        if (!is_null($this->timeToSend)) {
                            $sms['timeToSend'] = $this->timeToSend;
                        }
                        $sms_list[] = $sms;
                    }
                    $post_data = array(
                        "count" => count($sms_list),
                        "smslist" => $sms_list
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $this->api_url);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
                    $response = curl_exec($ch);
                    if (!curl_errno($ch)) {
                        $data = json_decode($response);
                        foreach ($data->responses as $value) {
                            if (isset($value->{"response-code"}) && $value->{"response-code"} == 200) {
                                $sent_count++;
                                $success = true;
                            }
                            else {
                                if (isset($value->{"respose-code"}) && $value->{"respose-code"} == 200) {
                                    $sent_count++;
                                    $success = true;
                                } 
                            }
                            $this->sent_message[] = array(
                                'message_id' => $value->messageid,
                                'mobile' => Functions::intlPhone($value->mobile, 'KE'),
                                'message' => '',
                                'network' => $value->networkid
                            );
                        }
                        foreach ($this->sent_message as &$item) {
                            foreach ($sms_list as $sms) {
                                if ($item['mobile'] === $sms['mobile']) {
                                    $item['message'] = $sms['message'];
                                }
                            }
                        }
                    }
                }

                if ($success) {
                    $feedback_message = '<p>Message sent successfully to '.$sent_count.' of '.count($this->mobile).' contacts</p>';
                    echo json_encode(array(
                        'status' => 1,
                        'title' => '<span class="text-success"><i class="fa fa-check"></i> Success!</span>',
                        'message' => $feedback_message
                    )); 
                }
                else {
                    echo json_encode(array(
                        'status' => 0,
                        'title' => '<span class="text-danger"><span class="fa fa-warning"></span> Error!</span>',
                        'message' => curl_error($ch)
                    ));
                }
                curl_close($ch);
                $this->saveMessage();
            } 
            else {
                echo json_encode(array(
                    'status' => 0,
                    'title' => '<span class="text-primary"><span class="fa fa-warning"></span> Info!</span>',
                    'message' => 'SMS sending not allowed.'
                ), JSON_PRETTY_PRINT+JSON_UNESCAPED_SLASHES);
            }
        }

        public function checkBalance () {
            $this->api_url = $this->api_url.'getbalance/';
            $post_data = array(
                'partnerID' => $this->partnerID,
                'apikey' => $this->apikey
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->api_url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            $response = json_decode(curl_exec($ch));
            return $response;
        }

        public function getDeliveryReport () {
            $this->api_url = $this->api_url.'getdlr/';
            $delivered = false;
            $this->message_id = $this->getUndelivered();
            if (is_array($this->message_id)) {
                foreach ($this->message_id as $key => $item) {
                    $post_data = array(
                        'partnerID' => $this->partnerID,
                        'apikey' => $this->apikey,
                        'messageID' => $item->message_id
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $this->api_url);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
                    $response = json_decode(curl_exec($ch));
                    $this->delivery_report = $response;
                    if (isset($this->delivery_report->{"delivery-status"}) && $this->delivery_report->{"delivery-status"} == 32) {
                        $this->updateDelivery();   
                        $delivered = true;
                    }  
                    curl_close($ch);  
                }
            }
            else {
                $post_data = array(
                    'partnerID' => $this->partnerID,
                    'apikey' => $this->apikey,
                    'messageID' => $this->message_id
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->api_url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
                $response = json_decode(curl_exec($ch));
                $this->delivery_report = $response;
                if (isset($this->delivery_report->{"delivery-status"}) && $this->delivery_report->{"delivery-status"} == 32) {
                    $this->updateDelivery(); 
                    $delivered = true;  
                }
                curl_close($ch);
            }
            echo json_encode(array(
                'status' => $delivered
            ));
        }

        public function saveMessage () {
            $date = date('Y-m-d H:i:s');
            $connection =  DatabaseController::connect();
            try {
                $query = $connection->prepare("INSERT INTO sent_sms_messages(message_id, mobile, message, date, network, status) VALUES(?, ?, ?, ?, ?, ?)");
                foreach ($this->sent_message as $message) {
                    $query->execute(array($message['message_id'], $message['mobile'], $message['message'], $date, $message['network'], 'Sent'));   
                }
                 DatabaseController::disconnect();
            } 
            catch (PDOException $e) {
                
            }
        }

        public function updateDelivery () {
            $connection =  DatabaseController::connect();
            try {
                $query = $connection->prepare("UPDATE sent_sms_messages SET status = ?, delivery_date = ? WHERE message_id = ?");
                $query->execute(array('Delivered', $this->delivery_report->{"delivery-time"}, $this->delivery_report->{"message-id"}));
                 DatabaseController::disconnect();
            } 
            catch (PDOException $e) {
                
            }
        }

        public static function getById ($id) {
            $connection =  DatabaseController::connect();
            $query = $connection->prepare("SELECT sent_sms_messages.*, DATE_FORMAT(date, '%a, %b %e %Y %H:%i') AS date, CASE WHEN network = 1 THEN 'Safaricom' WHEN network = 2 THEN 'Airtel' WHEN network = 3 THEN 'Telkom' WHEN network = 4 THEN 'Equitel' ELSE 'Unknown' END AS network, DATE_FORMAT(delivery_date, '%a, %b %e %Y %H:%i') AS delivery_date FROM sent_sms_messages WHERE id = ?");
            $query->execute(array($id));
             DatabaseController::disconnect();
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function dataTable () {
            $connection =  DatabaseController::connect();
            $query = "SELECT sent_sms_messages.*, DATE_FORMAT(date, '%a, %b %e %Y %H:%i') AS date, CASE WHEN network = 1 THEN 'Safaricom' WHEN network = 2 THEN 'Airtel' WHEN network = 3 THEN 'Telkom' WHEN network = 4 THEN 'Equitel' ELSE 'Unknown' END AS network FROM sent_sms_messages ";
            $query_params = array();
            $keyword = (isset($this->search['value'])) ? '%'.$this->search['value'].'%' : '%%';
            if (isset($this->search['value'])) {
                if (strpos($query, "WHERE") !== false) {
                    $query .= "AND ";   
                }
                else {
                    $query .= "WHERE ";
                }
                $query .= "(sent_sms_messages.mobile LIKE ? OR sent_sms_messages.message LIKE ?) ";
                for ($i=0; $i < 2; $i++) { 
                    $query_params[] = $keyword;
                }
            }
            if (isset($this->order)) {
                $order_col = $this->order['0']['column'];
                $column = '';
                switch ($order_col) {
                    case 0:
                        $column = 'sent_sms_messages.mobile';
                        break;

                    case 2:
                        $column = 'sent_sms_messages.date';
                        break;

                    case 3:
                        $column = 'network';
                        break;

                    case 4:
                        $column = 'sent_sms_messages.status';
                        break;
                    
                    default:
                        $column = 'sent_sms_messages.id';
                        break;
                }
                $query .= "ORDER BY ".$column." ".$this->order['0']['dir']." ";
            }
            else {
                $query .= "ORDER BY sent_sms_messages.id DESC ";
            }
            if ($this->length != '-1') {
                $query .= 'LIMIT '. $this->start .', '.$this->length;
            }
            $statement = $connection->prepare($query);
            $statement->execute($query_params);
             DatabaseController::disconnect();
			$results = $statement->fetchAll(PDO::FETCH_OBJ);
            $data = array();
            foreach ($results as $row) {
                $table_row = array();
                $table_row[] = $row->mobile;
                $table_row[] = Functions::limit_text($row->message, 10);
                $table_row[] = $row->date;
                $table_row[] = $row->network;
                $table_row[] = $row->status;
                $table_row[] = '<div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-xs viewMessageBtn" data-id="'.$row->id.'"><i class="fa fa-eye"></i></button>
                                </div>';

                $data[] = $table_row;
            }
            echo json_encode(array(
                "draw" => intval($this->draw),
                "recordsTotal" => count($results),
                "recordsFiltered" => $this->totalRecords(),
                "data" => $data
            ), JSON_PRETTY_PRINT+JSON_UNESCAPED_SLASHES);
        }
        public function totalRecords () {
            $connection =  DatabaseController::connect();
            $statement = "SELECT COUNT(id) FROM sent_sms_messages ";
            $query_params = array();
            $keyword = (isset($this->search['value'])) ? '%'.$this->search['value'].'%' : '%%';
            if (isset($this->search['value'])) {
                if (strpos($statement, "WHERE") !== false) {
                    $statement .= "AND ";   
                }
                else {
                    $statement .= "WHERE ";
                }
                $statement .= "(sent_sms_messages.mobile LIKE ? OR sent_sms_messages.message LIKE ?) ";
                for ($i=0; $i < 2; $i++) { 
                    $query_params[] = $keyword;
                }
            }
            $query = $connection->prepare($statement);
            $query->execute($query_params);
             DatabaseController::disconnect();
            return $query->fetchColumn();
        }

        public function getUndelivered () {
            $connection =  DatabaseController::connect();
            $query = $connection->prepare("SELECT message_id FROM sent_sms_messages WHERE status = ?");
            $query->execute(array('Sent'));
             DatabaseController::disconnect();
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }
        public function getContacts () {
            $connection =  DatabaseController::connect();
            $statement = "SELECT salutations.title AS salutation, first_name, surname, phone FROM contacts LEFT JOIN salutations ON contacts.salutation = salutations.id ";
            $query_params = array();
            for ($i=0; $i < count($this->contact); $i++) { 
                if ($i == 0) {
                    $statement .= "WHERE contacts.id = ? ";
                }
                else {
                    $statement .= "OR contacts.id = ? ";
                }
                $query_params[] = $this->contact[$i];
            }
            $query = $connection->prepare($statement);
            $query->execute($query_params);
             DatabaseController::disconnect();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>