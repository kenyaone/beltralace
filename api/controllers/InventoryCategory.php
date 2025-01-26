<?php
class InventoryCategory
{
    public $id = null;
    public $name = null;
    public $description = null;
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
        if (isset($data['name']) && !empty($data['name'])) {
            $this->name = $data['name'];
        }
        if (isset($data['description']) && !empty($data['description'])) {
            $this->description = $data['description'];
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
    }

    public function create()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO inventory_categories(name, description, author) VALUES(?, ?, ?)");
            $query->execute(array($this->name, $this->description, $this->author));
            $this->id = $connection->lastInsertId();
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Inventory category created successfully'
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "name" => "Inventory Category Created",
                    "description" => "Created inventory category: '" . $this->name . "' - '".$this->description."'",
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
                'title' => '<span class="text-danger"><span class="fa fa-warning"></span> Error!</span>',
                'message' => $e->getMessage()
            ));
        }
    }

    public function update()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE inventory_categories SET name = ?, description = ?, author = ? WHERE id = ?");
            $query->execute(array($this->name, $this->description, $this->author, $this->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Inventory category updated successfully'
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "name" => "Inventory Category Updated",
                    "description" => "Updated inventory category: '" . $this->name . "' - '".$this->description."'",
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

    public function delete()
    {
        $connection =  DatabaseController::connect();
        try {
            $inventory_category = InventoryCategory::getById($this->id);
            $query = $connection->prepare("DELETE FROM inventory_categories WHERE id = ?");
            $query->execute(array($this->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Inventory category deleted successfully',
                'id' => $this->id
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "name" => "Inventory Category Deleted",
                    "description" => "Deleted inventory category: '" . $inventory_category->name . "' - '".$inventory_category->description."'",
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
        $query = $connection->prepare("SELECT * FROM inventory_categories WHERE id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM inventory_categories");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT inventory_categories.*, users.username, DATE_FORMAT(inventory_categories.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(inventory_categories.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM inventory_categories LEFT JOIN users ON inventory_categories.author = users.id ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(inventory_categories.name LIKE ? OR inventory_categories.description LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($params['order'])) {
            $order_col = $params['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'inventory_categories.name';
                    break;

                default:
                    $column = 'inventory_categories.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $params['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY inventory_categories.id DESC ";
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
            $table_row[] = $row->username;
            $table_row[] = $row->created_at;
            $table_row[] = $row->updated_at;
            $table_row[] = '<div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary btn-sm edit-inventory-category-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-edit"></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-inventory-category-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>
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
        $statement = "SELECT COUNT(id) FROM inventory_categories ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(inventory_categories.name LIKE ? OR inventory_categories.description LIKE ?) ";
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
