<?php
class BlogVideo
{
    public $id = null;
    public $title = null;
    public $link = null;
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
        if (isset($data['title']) && !empty($data['title'])) {
            $this->title = $data['title'];
        }
        if (isset($data['link']) && !empty($data['link'])) {
            $this->link = $data['link'];
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
            $query = $connection->prepare("INSERT INTO blog_videos(title, link, description, author) VALUES(?, ?, ?, ?)");
            $query->execute(array($this->title, $this->link, $this->description, $this->author));
            $this->id = $connection->lastInsertId();
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Blog video created successfully'
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "title" => "Blog Video Created",
                    "description" => "Created blog video: '" . $this->title . "' - '".$this->description."'",
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
            $query = $connection->prepare("UPDATE blog_videos SET title = ?, link = ?,description = ?, author = ? WHERE id = ?");
            $query->execute(array($this->title, $this->link, $this->description, $this->author, $this->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Blog video updated successfully'
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "title" => "Blog Video Updated",
                    "description" => "Updated blog video: '" . $this->title . "' - '".$this->description."'",
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
            $inventory_category = BlogVideo::getById($this->id);
            $query = $connection->prepare("DELETE FROM blog_videos WHERE id = ?");
            $query->execute(array($this->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Blog video deleted successfully',
                'id' => $this->id
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "title" => "Blog Video Deleted",
                    "description" => "Deleted blog video: '" . $inventory_category->title . "' - '".$inventory_category->description."'",
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
        $query = $connection->prepare("SELECT * FROM blog_videos WHERE id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM blog_videos");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT blog_videos.*, users.username, DATE_FORMAT(blog_videos.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(blog_videos.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM blog_videos LEFT JOIN users ON blog_videos.author = users.id ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(blog_videos.title LIKE ? OR blog_videos.description LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($params['order'])) {
            $order_col = $params['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'blog_videos.title';
                    break;

                default:
                    $column = 'blog_videos.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $params['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY blog_videos.id DESC ";
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
            $table_row[] = $row->title;
            $table_row[] = $row->username;
            $table_row[] = $row->created_at;
            $table_row[] = $row->updated_at;
            $table_row[] = '<div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary btn-sm edit-blog-video-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-edit"></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-blog-video-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>
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
        $statement = "SELECT COUNT(id) FROM blog_videos ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(blog_videos.title LIKE ? OR blog_videos.description LIKE ?) ";
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
