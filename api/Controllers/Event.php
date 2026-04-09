<?php
class Event extends Page
{

    public $location = null;
    public $start_date = null;
    public $end_date = null;
    public $event_images = null;

    public function initializeParams($data = array())
    {
        $this->section = "events";
        $this->page_type = "event";
        parent::initializeParams($data);

        if (isset($data['location']) && !empty($data['location'])) {
            $this->location = $data['location'];
        }
        if (isset($data['start_date']) && !empty($data['start_date'])) {
            $start_date = new DateTime($data['start_date']);
            $this->start_date = $start_date->format('Y-m-d H:i:s');
        }
        if (isset($data['end_date']) && !empty($data['end_date'])) {
            $end_date = new DateTime($data['end_date']);
            $this->end_date = $end_date->format('Y-m-d H:i:s');
        }
        if (isset($data['page_id']) && !empty($data['page_id'])) {
            $this->page_id = $data['page_id'];
        }
        if (isset($data['tempFiles']) && !empty($data['tempFiles'])) {
            $this->tempFiles = $data['tempFiles'];
        }
        

        if($this->tempFiles){
            $this->uploadGalleryImages();
        }
    }

    public function create ()
    {
        ob_start();
        parent::create();
        ob_get_clean();

        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO events(location, start_date, end_date, page_id) VALUES(?, ?, ?, ?)");
            $query->execute(array($this->location, $this->start_date, $this->end_date, $this->id));
            $this->id = $connection->lastInsertId();
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Event created successfully'
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "page_id" => "Event Created",
                    "description" => "Created event: '" . $this->page_id . "' - '".$this->body."'",
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

    public function update ()
    {
        ob_start();
        parent::update();
        ob_get_clean();

        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE events SET location = ?, start_date = ?, end_date = ?, page_id = ? WHERE id = ?");
            $query->execute(array($this->location, $this->start_date, $this->end_date, $this->page_id, $this->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Event updated successfully'
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "page_id" => "Event Updated",
                    "description" => "Updated event: '" . $this->title . "' - '".$this->body."'",
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
            $inventory_item = Event::getById($this->id);

            ob_start();
            $this->page_id = $inventory_item->page_id;
            parent::delete();
            ob_get_clean();

            echo json_encode(array(
                'status' => 1,
                'message' => 'Event deleted successfully',
                'id' => $this->id
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "page_id" => "Event Deleted",
                    "description" => "Deleted event: '" . $inventory_item->title . "' - '".$inventory_item->body."'",
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
        $query = $connection->prepare("SELECT pages.title, pages.slug, pages.url, pages.meta_description, pages.body, pages.cover_image, pages.cover_image_thumbnail, pages.header_image, pages.published, events.* FROM events LEFT JOIN pages ON events.page_id = pages.id WHERE events.id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        $event = $query->fetch(PDO::FETCH_OBJ);
        $event->event_images = self::getEventImages($id);
        return $event;
    }

    public static function getByUrl($url)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT pages.title, pages.slug, pages.url, pages.meta_description, pages.body, pages.cover_image, pages.cover_image_thumbnail, pages.header_image, pages.published, events.*, DATE_FORMAT(events.start_date, '%b %e, %Y %l:%i%p') AS start_date_, DATE_FORMAT(events.end_date, '%b %e, %Y %l:%i%p') AS end_date_ FROM events LEFT JOIN pages ON events.page_id = pages.id WHERE pages.url = ?");
        $query->execute(array($url));
         DatabaseController::disconnect();
        $event = $query->fetch(PDO::FETCH_OBJ);
        $event->event_images = self::getEventImages($event->id);
        return $event;
    }

    public static function getFeaturedProduct()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT pages.title, pages.slug, pages.url, pages.meta_description, pages.body, pages.cover_image, pages.cover_image_thumbnail, pages.header_image, pages.published, events.* FROM events LEFT JOIN pages ON events.page_id = pages.id WHERE events.is_featured = ?");
        $query->execute(array(1));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM events");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getLatest()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT events.*, pages.*, users.username AS author, DATE_FORMAT(events.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(events.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM events 
            LEFT JOIN pages ON events.page_id = pages.id
            LEFT JOIN users ON pages.author = users.id
            WHERE pages.published = ? ORDER BY events.id DESC");
        $query->execute(array(1));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getPublished()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT events.*, pages.*, users.username AS author, DATE_FORMAT(events.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(events.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM events 
            LEFT JOIN pages ON events.page_id = pages.id
            LEFT JOIN users ON pages.author = users.id
            WHERE pages.published = ? ORDER BY RAND ()");
        $query->execute(array(1));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getUpcoming()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT events.*, pages.title, pages.slug, pages.url, pages.body, pages.cover_image_thumbnail, users.username, DATE_FORMAT(events.start_date, '%b %e, %Y') AS start_date, DATE_FORMAT(events.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM events 
            LEFT JOIN pages ON events.page_id = pages.id
            LEFT JOIN users ON pages.author = users.id 
            WHERE pages.published = ? AND events.start_date >= NOW() ");
        $query->execute(array(1));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getPast()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT events.*, pages.title, pages.url, pages.body, pages.cover_image_thumbnail, users.username, DATE_FORMAT(events.start_date, '%b %e, %Y %l:%i%p') AS start_date, DATE_FORMAT(events.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM events 
            LEFT JOIN pages ON events.page_id = pages.id
            LEFT JOIN users ON pages.author = users.id 
            WHERE pages.published = ? AND events.start_date < NOW() ");
        $query->execute(array(1));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT events.*, pages.title, pages.url, pages.body, pages.cover_image_thumbnail, users.username, DATE_FORMAT(events.start_date, '%b %e, %Y %l:%i%p') AS start_date, DATE_FORMAT(events.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM events 
            LEFT JOIN pages ON events.page_id = pages.id
            LEFT JOIN users ON pages.author = users.id ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(events.page_id LIKE ? OR pages.body LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($params['order'])) {
            $order_col = $params['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'events.page_id';
                    break;

                default:
                    $column = 'events.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $params['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY events.id DESC ";
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
            $thumbnail = $row->cover_image_thumbnail ? DIR .$row->cover_image_thumbnail .'?'.time() : ASSETS_PATH .'/admin/img/thumbnail.png';
            $table_row = array();
            $table_row[] = '<img src="'.$thumbnail.'" class="img-fluid img-thumbnail" style="height: 40px"/>';
            $table_row[] = $row->title;
            $table_row[] = $row->start_date;
            $table_row[] = $row->username;
            $table_row[] = $row->updated_at;

            $gallery_btn = '';
            if(strtotime($row->start_date) < time()){
                $gallery_btn = '<button type="button" class="btn btn-outline-info btn-sm gallery-event-btn" data-id="' . $row->id . '"><i class="fa fa-image"></i></button>';
            }
            $table_row[] = '<div class="btn-group">
                                    '.$gallery_btn.'
                                    <a href="'.DIR .$row->url.'" target="_blank" class="btn btn-outline-secondary btn-sm view-page-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-eye"></i></a>
                                    <button type="button" class="btn btn-outline-primary btn-sm edit-event-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-edit"></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-event-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>
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
        $statement = "SELECT COUNT(events.id) FROM events 
            LEFT JOIN pages ON events.page_id = pages.id ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(events.page_id LIKE ? OR pages.body LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }

    public static function getEventImages($id)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM event_images WHERE event_id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function addGalleryImages(){
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO event_images(name, event_id) VALUES(?, ?)");
            // echo json_encode($this->event_images);
            // exit;
            foreach($this->event_images as $event_image){
                $query->execute(array($event_image, $this->id));
            }
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Event images added successfully'
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "page_id" => "Event Image",
                    "description" => "Added ".count($this->event_images)." event images",
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

    public function uploadGalleryImages()
    {
        if (!file_exists('../uploads/img')) {
            mkdir('../uploads/img', 0777, true);
        }
        if (!file_exists('../uploads/img/pages')) {
            mkdir('../uploads/img/pages', 0777, true);
        }
        if (!file_exists('../uploads/img/pages/thumbnails')) {
            mkdir('../uploads/img/pages/thumbnails', 0777, true);
        }

        $dir = 'uploads/img/pages/';

        $event_images = array();
        if (is_array($this->tempFiles)) {
            foreach($this->tempFiles as $key => $tempFile){
                if (file_exists('../' . $tempFile)) {
                    list($img_width, $img_height) = getimagesize('../' . $tempFile);
                    $width = $img_width;
                    $height = $img_height;
                    $thumb_width = round($img_width/2);
                    $thumb_height = round($img_height/2);
    
                    $path_parts = pathinfo('../' . $tempFile);
                    $extension = $path_parts['extension'];
                    $newfilename = strtolower($this->slug . '-' . time() . '-'.$key.'.' . $extension);
                    $final_file = strtolower($this->slug . '-' . time() . '-'.$key.'.' . 'webp');
                    rename('../' . $tempFile, '../' . $dir . $newfilename);
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
                    $event_images[] = $dir . $final_file;
                }
            }
        }

        $this->event_images = $event_images;

    }

    public function deleteEventImage()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("DELETE FROM event_images WHERE id = ?");
            $query->execute(array($this->id));
             DatabaseController::disconnect();

            echo json_encode(array(
                'status' => 1,
                'message' => 'Event image deleted successfully',
                'id' => $this->id
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "page_id" => "Event Image Deleted",
                    "description" => "Deleted event image",
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

    public function publishEventImage()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE event_images SET is_published = ? WHERE id = ?");
            $query->execute(array(1, $this->id));
             DatabaseController::disconnect();

            echo json_encode(array(
                'status' => 1,
                'message' => 'Event image published successfully',
                'id' => $this->id
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "page_id" => "Event Image published",
                    "description" => "Published event image",
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
    public function unpublishEventImage()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE event_images SET is_published = ? WHERE id = ?");
            $query->execute(array(0, $this->id));
             DatabaseController::disconnect();

            echo json_encode(array(
                'status' => 1,
                'message' => 'Event image unpublished successfully',
                'id' => $this->id
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "page_id" => "Event Image Unpublished",
                    "description" => "Unpublished event image",
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
}
