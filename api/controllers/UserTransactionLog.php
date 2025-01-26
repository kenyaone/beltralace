<?php
class UserTransactionLog
{
    public $id = null;
    public $user_type = null;
    public $user_id = null;
    public $name = null;
    public $subject = null;
    public $description = null;
    public $object = null;
    public $item_id = null;
    public $unit_id = null;

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
        if (isset($data['user_id']) && !empty($data['user_id'])) {
            $this->user_id = $data['user_id'];
            $user = User::getById($this->user_id);
            $this->name = $user->first_name . " " . $user->last_name;
            $this->user_type = "User";
        }
        if (isset($data['name']) && !empty($data['name'])) {
            $this->name = $data['name'];
        }
        if (isset($data['subject']) && !empty($data['subject'])) {
            $this->subject = $data['subject'];
        }
        if (isset($data['description']) && !empty($data['description'])) {
            $this->description = $data['description'];
        }
        if (isset($data['object']) && !empty($data['object'])) {
            $this->object = $data['object'];
        }
        if (isset($data['item_id']) && !empty($data['item_id'])) {
            $this->item_id = $data['item_id'];
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

    public function create()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO user_transaction_logs(user_type, user_id, name, subject, description, object, item_id) VALUES(?, ?, ?, ?, ?, ?, ?)");
            $query->execute(array($this->user_type, $this->user_id, $this->name, $this->subject, $this->description, $this->object, $this->item_id));
             DatabaseController::disconnect();
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'title' => '<span class="text-danger"><span class="fa fa-warning"></span> Error!</span>',
                'message' => $e->getMessage()
            ));
        }
    }

    public static function getByUser($id)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT user_transaction_logs.*, DATE_FORMAT(user_transaction_logs.date, '%b %e, %Y %l:%i%p') AS log_date, DATE_FORMAT(user_transaction_logs.date, '%l:%i%p') AS log_time, TIMEDIFF(NOW(), user_transaction_logs.date) AS time_difference FROM user_transaction_logs WHERE user_id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT user_transaction_logs.*, DATE_FORMAT(user_transaction_logs.date, '%b %e, %Y %l:%i %p') AS date FROM user_transaction_logs ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(user_transaction_logs.name LIKE ?) ";
            for ($i = 0; $i < 1; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($params['order'])) {
            $order_col = $params['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'user_transaction_logs.name';
                    break;

                default:
                    $column = 'user_transaction_logs.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $params['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY user_transaction_logs.id DESC ";
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
            $table_row[] = $row->name;
            $table_row[] = $row->user_type;
            $table_row[] = $row->subject;
            $table_row[] = $row->description;
            $table_row[] = $row->date;
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
        $statement = "SELECT COUNT(user_transaction_logs.id) FROM user_transaction_logs ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(user_transaction_logs.name LIKE ?) ";
            for ($i = 0; $i < 1; $i++) {
                $query_params[] = $keyword;
            }
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }

    public function getUserDetails()
    {
        $user = null;
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            }

            $jwt = $matches[1];
            if (!$jwt) {
            }

            try {
                $token = JWT::decode($jwt, new Key($this->secretKey, 'HS256'));
                $this->user_type = $token->user_type;
                $user = $token->user;
            } catch (Exception $e) {
            }
        } else {
            if (isset($_COOKIE['jwt'])) {
                try {
                    $token = JWT::decode($_COOKIE['jwt'], new Key($this->secretKey, 'HS256'));
                    $this->user_type = $token->user_type;
                    $user = $token->user;
                } catch (Exception $e) {
                }
            } else {
            }
        }
        $this->user_id = isset($user->id) ? $user->id : null;
        $this->name = isset($user->name) ? $user->name : null;
    }
}
