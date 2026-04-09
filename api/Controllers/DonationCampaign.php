<?php
class DonationCampaign
{
    public $id = null;
    public $title = null;
    public $target = null;
    public $contributions = null;
    public $slug = null;
    public $description = null;
    public $cover_image = null;
    public $cover_image_thumbnail = null;
    public $published = null;
    public $featured = null;
    public $tempFile = null;
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
        if (isset($data['target']) && !empty($data['target'])) {
            $this->target = str_replace(",", "", $data['target']);
        }
        if (isset($data['contributions']) && !empty($data['contributions'])) {
            $this->contributions = str_replace(",", "", $data['contributions']);
        }
        if (isset($data['slug']) && !empty($data['slug'])) {
            $this->slug = $data['slug'];
        }
        if (isset($data['description']) && !empty($data['description'])) {
            $this->description = $data['description'];
        }
        if (isset($data['tempFile']) && !empty($data['tempFile'])) {
            $this->tempFile = $data['tempFile'];
        }
        if (isset($data['cover_image']) && !empty($data['cover_image'])) {
            $this->cover_image = $data['cover_image'];
        }
        if (isset($data['cover_image_thumbnail']) && !empty($data['cover_image_thumbnail'])) {
            $this->cover_image_thumbnail = $data['cover_image_thumbnail'];
        }
        if (isset($data['published']) && !empty($data['published'])) {
            $this->published = $data['published'];
        }
        if (isset($data['featured']) && !empty($data['featured'])) {
            $this->featured = $data['featured'];
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
        if($this->tempFile){
            $this->uploadCoverImage();
        }
    }

    public function create()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO donation_campaigns(title, target, contributions, slug, description, cover_image, cover_image_thumbnail, published, featured, author) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->execute(array($this->title, $this->target, $this->contributions, $this->slug, $this->description, $this->cover_image, $this->cover_image_thumbnail, $this->published, $this->featured, $this->author));
            $this->id = $connection->lastInsertId();
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Donation campaign created successfully'
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "title" => "Donation campaign Created",
                    "description" => "Created donation campaign: '" . $this->title . "' - '" . $this->description . "'",
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
            $query = $connection->prepare("UPDATE donation_campaigns SET title = ?, target = ?, contributions = ?, slug = ?,description = ?, cover_image = ?, cover_image_thumbnail = ?, published = ?, featured = ?, author = ? WHERE id = ?");
            $query->execute(array($this->title, $this->target, $this->contributions, $this->slug, $this->description, $this->cover_image, $this->cover_image_thumbnail, $this->published, $this->featured, $this->author, $this->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Donation campaign updated successfully'
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "title" => "Donation campaign Updated",
                    "description" => "Updated donation campaign: '" . $this->title . "' - '" . $this->description . "'",
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
            $inventory_category = DonationCampaign::getById($this->id);
            $query = $connection->prepare("DELETE FROM donation_campaigns WHERE id = ?");
            $query->execute(array($this->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Donation campaign deleted successfully',
                'id' => $this->id
            ));
            if(file_exists('../uploads/img/donation_campaigns/' .$inventory_category->cover_image)){
                unlink('../uploads/img/donation_campaigns/' .$inventory_category->cover_image);
            }

            if(file_exists('../uploads/img/donation_campaigns/thumbnail/' .$inventory_category->cover_image_thumbnail)){
                unlink('../uploads/img/donation_campaigns/thumbnail/' .$inventory_category->cover_image_thumbnail);
            }
            

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "title" => "Donation campaign Deleted",
                    "description" => "Deleted donation campaign: '" . $inventory_category->title . "' - '" . $inventory_category->description . "'",
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

    public function publish()
    {
        $connection =  DatabaseController::connect();
        try {
            $inventory_category = DonationCampaign::getById($this->id);
            $query = $connection->prepare("UPDATE donation_campaigns SET published = ? WHERE id = ?");
            $query->execute(array(1, $this->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Donation campaign published successfully',
                'id' => $this->id
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "title" => "Donation campaign published",
                    "description" => "Published donation campaign: '" . $inventory_category->title . "' - '" . $inventory_category->description . "'",
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

    public function unpublish()
    {
        $connection =  DatabaseController::connect();
        try {
            $inventory_category = DonationCampaign::getById($this->id);
            $query = $connection->prepare("UPDATE donation_campaigns SET published = ? WHERE id = ?");
            $query->execute(array(0, $this->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Donation campaign unpublished successfully',
                'id' => $this->id
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "title" => "Donation campaign unpublished",
                    "description" => "Unpublished donation campaign: '" . $inventory_category->title . "' - '" . $inventory_category->description . "'",
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
        $query = $connection->prepare("SELECT * FROM donation_campaigns WHERE id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM donation_campaigns");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getPublished()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM donation_campaigns WHERE published = ?");
        $query->execute(array(1));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getFeatured()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM donation_campaigns WHERE featured = ?");
        $query->execute(array(1));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT donation_campaigns.*, users.username, DATE_FORMAT(donation_campaigns.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(donation_campaigns.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM donation_campaigns LEFT JOIN users ON donation_campaigns.author = users.id ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(donation_campaigns.title LIKE ? OR donation_campaigns.description LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($params['order'])) {
            $order_col = $params['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'donation_campaigns.title';
                    break;

                default:
                    $column = 'donation_campaigns.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $params['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY donation_campaigns.id DESC ";
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
            $status = '<span class="badge bg-warning p-1 me-2"> </span>';
            $publish_btn = '<button type="button" class="btn btn-outline-success btn-sm publish-donation-campaign-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-check"></i></button>';
            if($row->published){
                $status = '<span class="badge bg-success p-1 me-2"> </span>';
                $publish_btn = '<button type="button" class="btn btn-outline-warning btn-sm unpublish-donation-campaign-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-times"></i></button>';
            }
            $table_row[] = $status .$row->title;
            $table_row[] = $row->username;
            $table_row[] = $row->created_at;
            $table_row[] = $row->updated_at;
            $table_row[] = '<div class="btn-group">
                                    '.$publish_btn.'
                                    <button type="button" class="btn btn-outline-secondary btn-sm view-donation-campaign-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-eye"></i></button>
                                    <button type="button" class="btn btn-outline-primary btn-sm edit-donation-campaign-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-edit"></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-donation-campaign-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>
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
        $statement = "SELECT COUNT(id) FROM donation_campaigns ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(donation_campaigns.title LIKE ? OR donation_campaigns.description LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }

    public function uploadCoverImage()
    {
        if (!file_exists('../uploads/img')) {
            mkdir('../uploads/img', 0777, true);
        }
        if (!file_exists('../uploads/img/donation_campaigns')) {
            mkdir('../uploads/img/donation_campaigns', 0777, true);
        }
        if (!file_exists('../uploads/img/donation_campaigns/thumbnails')) {
            mkdir('../uploads/img/donation_campaigns/thumbnails', 0777, true);
        }

        $dir = 'uploads/img/donation_campaigns/';

        if ($this->tempFile) {
            if (file_exists('../' . $this->tempFile)) {
                list($img_width, $img_height) = getimagesize('../' . $this->tempFile);
                $width = $img_width;
                $height = $img_height;
                $thumb_width = round($img_width/2);
                $thumb_height = round($img_height/2);


                $path_parts = pathinfo('../' . $this->tempFile);
                $extension = $path_parts['extension'];
                $newfilename = strtolower($this->slug . '-' . time() . '.' . $extension);
                $final_file = strtolower($this->slug . '-' . time() . '.' . 'webp');
                rename('../' . $this->tempFile, '../' . $dir . $newfilename);
                Functions::resize_image('../' . $dir . $newfilename, '../'.$dir.$newfilename, $width);
                Functions::resize_image('../' . $dir . $newfilename, '../'.$dir.'thumbnails/'.$newfilename, $thumb_width);
                Functions::webp_image('../' . $dir . $newfilename, '../' . $dir . $final_file, $width, $height, 85);
                Functions::webp_image('../' . $dir . 'thumbnails/' . $newfilename, '../' . $dir . 'thumbnails/' . $final_file, $thumb_width, $thumb_height, 85);
                if (file_exists('../' . $dir . $newfilename)) {
                    unlink('../' . $dir . $newfilename);
                }
                if (file_exists('../' . $dir . 'thumbnails/' . $newfilename)) {
                    unlink('../' . $dir . 'thumbnails/' . $newfilename);
                }
                $this->cover_image = $dir . $final_file;
                $this->cover_image_thumbnail = $dir . 'thumbnails/' . $final_file;
            }
        }
    }
}
