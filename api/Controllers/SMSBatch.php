<?php

include_once 'SMSTemplate.php';
include_once 'SMSSubscription.php';
include_once 'SMSOutbox.php';

class SMSBatch
{
    public $id = null;
    public $subject = null;
    public $message = null;
    public $batch_no = null;
    public $time_to_send = null;
    public $template_id = null;
    public $author = null;

    public $object = null;
    public $action = null;

    /* Datatable */

    public $draw = null;
    public $columns = null;
    public $start = 0;
    public $length = null;
    public $search = null;
    public $order = null;

    public function __construct($data = array())
    {
        if (isset($data['id']) && !empty($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['subject']) && !empty($data['subject'])) {
            $this->subject = $data['subject'];
        }
        if (isset($data['message']) && !empty($data['message'])) {
            $this->message = $data['message'];
        }
        if (isset($data['time_to_send']) && !empty($data['time_to_send'])) {
            $this->time_to_send = $data['time_to_send'];
        }
        if (isset($data['template_id']) && !empty($data['template_id'])) {
            $this->template_id = $data['template_id'];
        }
        if (isset($data['author']) && !empty($data['author'])) {
            $this->author = $data['author'];
        }


        if (isset($data['object']) && !empty($data['object'])) {
            $this->object = $data['object'];
        }
        if (isset($data['action']) && !empty($data['action'])) {
            $this->action = $data['action'];
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

        if (isset($this->time_to_send)) {
            $date = new DateTime($this->time_to_send);
            $this->time_to_send = $date->format('Y-m-d H:i:s');
        }
        if (isset($this->template_id)) {
            $template = SMSTemplate::getById($this->template_id);
            $this->subject = $template->subject;
            $this->message = $template->message;
        }
    }

    public function create()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO sms_batches(subject, message, time_to_send, in_queue, author) VALUES(?, ?, ?, ?, ?)");
            $query->execute(array($this->subject, $this->message, $this->time_to_send, 1, $this->author));
            $this->id = $connection->lastInsertId();
             DatabaseController::disconnect();

            if ($this->queueSubscriberMessages()) {
                echo json_encode(array(
                    'status' => 1,
                    'message' => 'SMS queued successfully'
                ));

                $data = array(
                    "user_id" => $this->author,
                    "subject" => "Batch Queued",
                    "description" => "Queued '" . $this->subject . "' to be send on " . $this->time_to_send,
                    "object" => $this->object,
                    "item_id" => $this->id,
                );
                $transaction_log = new UserTransactionLog();
                $transaction_log->initializeParams($data);
                $transaction_log->create();
            }
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
        }
    }

    public static function getById($id)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM sms_batches WHERE id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        $batch = $query->fetch(PDO::FETCH_OBJ);
        $batch->messages = self::getBatchMessages($id);
        return $batch;
    }

    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM sms_batches");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getUpcoming()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT sms_batches.*, DATE_FORMAT(sms_batches.time_to_send, '%b %e, %Y %l:%i%p') AS time_to_send, TIMEDIFF(sms_batches.time_to_send, NOW()) AS time_difference FROM sms_batches WHERE time_to_send > NOW() ORDER BY time_difference ASC LIMIT 7");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function sendQueuedMessages()
    {
        $batches = $this->getQueuedBatches();

        if (count($batches) > 0) {
            foreach ($batches as $batch) {
                if ($batch->in_queue && !$batch->send_status) {
                    $this->id = $batch->id;
                    $data = $this->prepareMessagesData();
                    $sms_subscription = new SMSSubscription();
                    $sms_subscription->initializeParams($data);
                    $response = (object) json_decode($sms_subscription->send());

                    $recipients = $response->SMSMessageData->Recipients;

                    if (count($recipients) > 0) {
                        $this->updateBatchStatus();
                        foreach ($recipients as $recipient) {
                            SMSOutbox::updateMessageSendInfo($recipient, $this->id);
                        }
                    }
                }
            }
        }
    }

    public function prepareMessagesData()
    {
        $batch = self::getById($this->id);
        $recipients = array();
        foreach ($batch->messages as $outbox_message) {
            $recipients[] = $outbox_message->phone_number;
        }

        $data = array(
            "message" => $batch->message,
            "recipients" => implode(", ", $recipients),
            "batch_id" => $this->id
        );
        return $data;
    }
    public function getQueuedBatches()
    {
        $connection =  DatabaseController::connect();
        $current_date_time = date("Y-m-d H:i:s");
        $query = $connection->prepare("SELECT * FROM sms_batches WHERE time_to_send < ?");
        $query->execute(array($current_date_time));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getBatchMessages($id)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM sms_outbox WHERE batch_id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function queueSubscriberMessages()
    {
        $this->batch_no = Functions::generateSMSBatchNo($this->id);
        $subscribers = SMSSubscription::getList();

        $success = 0;
        $subscribers_count = 0;
        foreach ($subscribers as $subscriber) {
            $params = array(
                'batch_id' => $this->id,
                'phone_number' => $subscriber->phone_number
            );

            if ($subscriber->subscribe) {
                $sms_outbox = new SMSOutbox();
                $sms_outbox->initializeParams($params);
                if ($sms_outbox->create()) {
                    $success++;
                }
                $subscribers_count++;
            }
        }

        if ($success == $subscribers_count) {
            $this->updateBatchNo();
            return true;
        }

        return false;
    }

    public function updateBatchNo()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE sms_batches SET batch_no = ? WHERE id = ?");
            $query->execute(array($this->batch_no, $this->id));
             DatabaseController::disconnect();
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
        }
    }

    public function updateBatchStatus()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE sms_batches SET send_status = ? WHERE id = ?");
            $query->execute(array(1, $this->id));
             DatabaseController::disconnect();
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
        }
    }

    public function updateBatchMessages()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE sms_outbox SET send_status = ? WHERE batch_id = ?");
            $query->execute(array(1, $this->id));
             DatabaseController::disconnect();
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
        }
    }

    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT sms_batches.*, DATE_FORMAT(sms_batches.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(sms_batches.time_to_send, '%b %e, %Y %l:%i%p') AS time_to_send FROM sms_batches ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(sms_batches.subject LIKE ? OR sms_batches.message LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($params['order'])) {
            $order_col = $params['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'sms_batches.subject';
                    break;

                default:
                    $column = 'sms_batches.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $params['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY sms_batches.id DESC ";
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
            $table_row[] = $row->batch_no;
            $table_row[] = $row->subject;
            // $table_row[] = $row->send_status;
            if ($row->send_status) {
                $badge = '<span class="badge bg-success">Sent</span>';
                $buttons = '
                            <div class="btn-group">
                            <a href="' . DIRADMIN . 'sms-sent/view/' . $row->id . '" class="btn btn-outline-secondary btn-sm view-sms-batch-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-eye"></i></a>
                            </div>
                ';
            } else {
                if ($row->in_queue) {
                    $badge = '<span class="badge bg-warning">Queued</span>';
                    $buttons = '
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-sm pause-sms-batch-btn" data-id="' . $row->id . '"><i class="fa fa-pause"></i></button>
                                    <a href="' . DIRADMIN . 'sms-sent/view/' . $row->id . '" class="btn btn-outline-secondary btn-sm view-sms-batch-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-eye"></i></a>
                                </div>
                    ';
                } else {
                    $badge = '<span class="badge bg-secondary">Paused</span>';
                    $buttons = '
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm resume-sms-batch-btn" data-id="' . $row->id . '"><i class="fa fa-play"></i></button>
                                    <a href="' . DIRADMIN . 'sms-sent/view/' . $row->id . '" class="btn btn-outline-secondary btn-sm view-sms-batch-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-eye"></i></a>
                                </div>
                    ';
                }
            }
            $table_row[] = $badge;
            $table_row[] = "Admin";
            $table_row[] = $row->time_to_send;
            $table_row[] = $row->created_at;
            $table_row[] = $buttons;

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
        $statement = "SELECT COUNT(id) FROM sms_batches ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(sms_batches.subject LIKE ? OR sms_batches.message LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }
}
