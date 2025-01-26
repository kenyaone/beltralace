<?php

use AfricasTalking\SDK\AfricasTalking;

class SMSSubscription
{
    public $id = null;
    public $at = null;
    public $sms = null;
    public $checkout_token = null;
    public $phone_number = null;
    public $subscribe = null;
    public $short_code = null;
    public $keyword = null;
    public $update_type = null;
    public $batch_id = null;
    public $message = null;
    public $recipients = null;


    /* Datatable */

    public $draw = null;
    public $columns = null;
    public $start = 0;
    public $length = null;
    public $search = null;
    public $order = null;

    public function __construct($data = array())
    {
        $at = new AfricasTalking(SMS_USERNAME, SMS_APIKEY);
        $this->at = $at;

        if (isset($data['phoneNumber']) && !empty($data['phoneNumber'])) {
            $this->phone_number = $data['phoneNumber'];
        }
        if (isset($data['shortCode']) && !empty($data['shortCode'])) {
            $this->short_code = $data['shortCode'];
        }
        if (isset($data['keyword']) && !empty($data['keyword'])) {
            $this->keyword = $data['keyword'];
        }
        if (isset($data['updateType']) && !empty($data['updateType'])) {
            $this->update_type = $data['updateType'];
        }
        if (isset($data['batch_id']) && !empty($data['batch_id'])) {
            $this->batch_id = $data['batch_id'];
        }
        if (isset($data['message']) && !empty($data['message'])) {
            $this->message = $data['message'];
        }
        if (isset($data['recipients']) && !empty($data['recipients'])) {
            $this->recipients = $data['recipients'];
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

    public function initializeParams($params)
    {
        $this->__construct($params);
    }

    public function send()
    {
        $url = 'https://content.africastalking.com/version1/messaging';

        $data = array(
            'username' => SMS_USERNAME,
            'to' => $this->recipients,
            'from' => SMS_SHORTCODE,
            'keyword' => SMS_KEYWORD,
            'message' => $this->message,
            'bulkSMSMode' => '0',
            "requestId" => $this->batch_id,
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "apikey: " . SMS_APIKEY,
            "Content-Type: application/x-www-form-urlencoded",
            "Accept: application/json",
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);
        Logger::logApiResponse($response, 'send_premium');
        return $response;
    }

    public static function getById($id)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM sms_subscribers WHERE id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM sms_subscribers");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getSubscriptionWeeklyTrend (){
        $current_week_subs = self::getCurrentWeekSubscribers()->subscribers;
        $previous_week_subs_milestone = self::getSubscribersByLastWeek()->subscribers;

        $trend = $previous_week_subs_milestone != 0 ? (($current_week_subs - $previous_week_subs_milestone)/$previous_week_subs_milestone) * 100 : 100;
        return $trend;
    }

    private static function getCurrentWeekSubscribers (){
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT COUNT(sms_subscribers.id) as subscribers FROM sms_subscribers WHERE WEEK(created_at) = WEEK(NOW())");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    private static function getPreviousWeekSubscribers (){
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT COUNT(sms_subscribers.id) as subscribers FROM sms_subscribers WHERE WEEK(created_at) = WEEK(NOW())-1");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    private static function getSubscribersByLastWeek (){
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT COUNT(sms_subscribers.id) as subscribers FROM sms_subscribers WHERE WEEK(created_at) <= WEEK(NOW())-1");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getSubscriberMessages ($phone_number){
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM sms_outbox WHERE phone_number = ? ");
        $query->execute(array($phone_number));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT sms_subscribers.*, DATE_FORMAT(sms_subscribers.updated_at, '%b %e, %Y %T') AS updated_at FROM sms_subscribers ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';

        if (isset($this->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(sms_subscribers.phone_number LIKE ?) ";
            for ($i = 0; $i < 1; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($params['order'])) {
            $order_col = $params['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'sms_subscribers.phone_number';
                    break;

                default:
                    $column = 'sms_subscribers.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $params['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY sms_subscribers.id DESC ";
        }
        if ($this->length != '-1') {
            $query .= 'LIMIT ' . $this->start . ', ' . $this->length;
        }
        $statement = $connection->prepare($query);
        $statement->execute($query_params);
         DatabaseController::disconnect();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        $data = array();
        foreach ($results as $row) {
            $table_row = array();
            $table_row[] = $row->phone_number;
            $table_row[] = $row->keyword;

            if($row->subscribe){
                $badge = '<span class="badge bg-success">Active</span>';
            }
            else{
                $badge = '<span class="badge bg-warning">Inctive</span>';
            }
            $table_row[] = $badge;
            $table_row[] = count(self::getSubscriberMessages($row->phone_number));
            $table_row[] = $row->updated_at;
            $table_row[] = '<div class="btn-group">
                                    <a href="#" class="btn-primary btn-xs btn editAreaUnitBtn" data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn-danger btn-xs btn deleteAreaUnitBtn" data-id="' . $row->id . '" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                </div>';
            $data[] = $table_row;
        }
        echo json_encode(array(
            "draw" => intval($this->draw),
            "recordsTotal" => count($results),
            "recordsFiltered" => $this->totalRecords(),
            "data" => $data
        ), JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES);
    }

    public function totalRecords()
    {
        $connection =  DatabaseController::connect();
        $statement = "SELECT COUNT(id) FROM sms_subscribers ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(sms_subscribers.phone_number LIKE ?) ";
            for ($i = 0; $i < 1; $i++) {
                $query_params[] = $keyword;
            }
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }

    public function generateCheckoutToken(){
        try {
            // Get the token service 
            $token = $this->at->token();
            $result = (object) $token->createCheckoutToken([
                'phoneNumber' => $this->phone_number
            ]);

            $this->checkout_token =  $result->data->token;
        } catch (\Throwable $th) {
        }
    }

    public function createSubscription(){
        $this->generateCheckoutToken();
        try {
            // Get the SMS service 
            $sms = $this->at->sms();

            // Create the subscription
            $result = (object) $sms->createSubscription([
                'shortCode'      => SMS_SHORTCODE,
                'keyword'        => $this->keyword,
                'phoneNumber'    => $this->phone_number,
                'checkoutToken'  => $this->checkout_token
            ]);

            if ($result->data->status == 'Success') {
                $this->subscribe = 1;
                return true;
            }

            return false;
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    public function deleteSubscription(){
        try {
            // Get the SMS service 
            $sms = $this->at->sms();

            // Delete the subscription
            $result = $sms->deleteSubscription([
                'shortCode'   => SMS_SHORTCODE,
                'keyword'     => SMS_KEYWORD,
                'phoneNumber' => $this->phone_number
            ]);

            if ($result->status == 'Success') {
                return true;
            }

            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function subscribe (){
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO sms_subscribers(phone_number, keyword, subscribe) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE subscribe = ?");
            $result = $query->execute(array($this->phone_number, $this->keyword, 1, 1));
            $this->id = $connection->lastInsertId();
             DatabaseController::disconnect();
            if ($this->id) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function unsubscribe ()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE sms_subscribers SET subscribe = ? WHERE phone_number = ? AND keyword = ? ");
            $query->execute(array(0, $this->phone_number, $this->keyword));
             DatabaseController::disconnect();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
