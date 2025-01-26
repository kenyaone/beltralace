<?php

class SMSOutbox{
    public $id = null;
    public $batch_id = null;
    public $phone_number = null;
    public $send_id = null;
    public $delivery_status = null;
    public $delivery_report = "";
    public $network_code = "";

    /* Datatable */

    public $draw = null;
    public $columns = null;
    public $start = 0;
    public $length = null;
    public $search = null;
    public $order = null;

    public function __construct ($data = array()) {
        if (isset($data['id']) && !empty($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['batch_id']) && !empty($data['batch_id'])) {
            $this->batch_id = $data['batch_id'];
        }
        if (isset($data['phone_number']) && !empty($data['phone_number'])) {
            $this->phone_number = $data['phone_number'];
        }
        if (isset($data['phoneNumber']) && !empty($data['phoneNumber'])) {
            $this->phone_number = $data['phoneNumber'];
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $this->send_id = $data['id'];
        }
        if (isset($data['status']) && !empty($data['status'])) {
            $this->delivery_status = $data['status'];
        }
        if (isset($data['failureReason']) && !empty($data['failureReason'])) {
            $this->delivery_report = $data['failureReason'];
        }
        else{
            $this->delivery_report = isset($data['status'])? $data['status'] : null;
        }
        if (isset($data['networkCode']) && !empty($data['networkCode'])) {
            $this->network_code = $data['networkCode'];
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
    }

    public function create () {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO sms_outbox(batch_id, phone_number) VALUES(?, ?)");
            $query->execute(array($this->batch_id, $this->phone_number));
            $this->id = $connection->lastInsertId();
             DatabaseController::disconnect();

            if($this->id){
                return true;
            }

            return false;
        } 
        catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
        }
    }

    public static function getById ($id) {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM sms_outbox WHERE id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getList () {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM sms_outbox");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getQueuedTrend(){
        $connection =  DatabaseController::connect();
    }

    public function updateDeliveryReport () {
        $connection =  DatabaseController::connect();
        try {
            $data = array(
                'delivery_status' => $this->delivery_status,
                'delivery_report' => $this->delivery_report,
                'network_code' => $this->network_code,
                'send_id' => $this->send_id,
            );

            $query = $connection->prepare("UPDATE sms_outbox SET delivery_status = ?, delivery_report = ? WHERE send_id = ? ");
            $query->execute(array($this->delivery_status, $this->delivery_report, $this->send_id));
             DatabaseController::disconnect();

        } 
        catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
            exit;
        }
    }

    public static function updateMessageSendInfo($send_info, $batch_id){
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE sms_outbox SET send_status = ?, send_id = ? WHERE batch_id = ? AND phone_number LIKE ? ");
            $query->execute(array(1, $send_info->messageId, $batch_id, "%".substr($send_info->number, -9)));
             DatabaseController::disconnect();

        } 
        catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
            exit;
        }
    }

    public function dataTable () {
        $connection =  DatabaseController::connect();
        $query = "SELECT sms_outbox.*, sms_batches.in_queue as batch_queue_status, DATE_FORMAT(sms_outbox.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(sms_outbox.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM sms_outbox LEFT JOIN sms_batches ON sms_outbox.batch_id = sms_batches.id ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%'.$this->search['value'].'%' : '%%';

        $query .= "WHERE batch_id = ? ";
        $query_params[] = $this->batch_id;
        
        if (isset($this->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";   
            }
            else {
                $query .= "WHERE ";
            }
            $query .= "(sms_outbox.phone_number LIKE ? OR sms_outbox.phone_number LIKE ?) ";
            for ($i=0; $i < 2; $i++) { 
                $query_params[] = $keyword;
            }
        }
        if (isset($params['order'])) {
            $order_col = $params['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'sms_outbox.phone_number';
                    break;
                
                default:
                    $column = 'sms_outbox.id';
                    break;
            }
            $query .= "ORDER BY ".$column." ".$params['order']['0']['dir']." ";
        }
        else {
            $query .= "ORDER BY sms_outbox.id DESC ";
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

            if($row->send_status){
                $send_status = '<span class="badge bg-success">Sent</span>';
            }
            else{
                if($row->batch_queue_status){
                    $send_status = '<span class="badge bg-warning">Pending</span>';
                }
                else{
                    $send_status = '<span class="badge bg-secondary">Paused</span>';
                }
            }


            if($row->delivery_status){
                $delivery_status = '<span class="badge bg-success">Delivered</span>';
            }
            else{
                $delivery_status = '<span class="badge bg-warning">Pending</span>';
            }
            $table_row[] = $row->phone_number;
            $table_row[] = $send_status;
            $table_row[] = $delivery_status;
            $table_row[] = $row->updated_at;

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
        $statement = "SELECT COUNT(id) FROM sms_outbox ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%'.$this->search['value'].'%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";   
            }
            else {
                $statement .= "WHERE ";
            }
            $statement .= "(sms_outbox.phone_number LIKE ? OR sms_outbox.phone_number LIKE ?) ";
            for ($i=0; $i < 2; $i++) { 
                $query_params[] = $keyword;
            }
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }
}