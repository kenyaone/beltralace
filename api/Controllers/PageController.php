<?php

namespace App\Controllers;

use \PDO;
use \PDOException;
use App\Models\Page;
use App\Models\Datatable;
use App\Helpers\HelperFunctions;

class PageController
{
    public $page = null;
    public $datatable = null;
    public $data = null;


    public function __construct($data = array())
    {
        $this->page = new Page($data);
        $this->datatable = new Datatable($data);
        $this->data = $data;
    }

    public function create()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO pages(title, sub_title, section, slug, url, page_type, meta_description, body, header_image, published, author) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->execute(array($this->page->title, $this->page->sub_title, $this->page->section, $this->page->slug, $this->page->url, $this->page->page_type, $this->page->meta_description, $this->page->body, $this->page->header_image, $this->page->published, $this->page->author));
            $this->page->id = $connection->lastInsertId();
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Page created',
                'data' => $this->page
            );

        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            http_response_code(500);
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            );
        }
    }
    public function update()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE pages SET title = ?, sub_title = ?, slug = ?, url = ?, page_type = ?, meta_description = ?, body = ?, header_image = ?, published = ?, author = ? WHERE id = ?");
            $query->execute(array($this->page->title, $this->page->sub_title, $this->page->slug, $this->page->url, $this->page->page_type, $this->page->meta_description, $this->page->body, $this->page->header_image, $this->page->published, $this->page->author, $this->page->id));
             DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Page updated',
                'data' => $this->page
            );

        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            http_response_code(500);
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            );
        }
    }
    public static function updateCoverImage($data)
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE pages SET cover_image = ?, cover_image_thumbnail = ? WHERE id = ?");
            $query->execute(array($data['cover_image'], $data['cover_image_thumbnail'], $data['id']));
             DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Cover image updated',
            );

        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            http_response_code(500);
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            );
        }
    }
    public static function updateHeaderImage($data)
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE pages SET header_image = ? WHERE id = ?");
            $query->execute(array($data['header_image'], $data['id']));
             DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Header image updated',
            );

        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            http_response_code(500);
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            );
        }
    }
    public function delete()
    {
        $connection =  DatabaseController::connect();
        try {
            $page = self::getById($this->page->id);
            $query = $connection->prepare("DELETE FROM pages WHERE pages.id = ?");
            $query->execute(array($this->page->id));
             DatabaseController::disconnect();
            return (object)array(
                'status' => 1,
                'message' => 'Page deleted',
            );
            // if(file_exists('../uploads/img/pages/' .$page->cover_image)){
            //     unlink('../uploads/img/pages/' .$page->cover_image);
            // }

            // if(file_exists('../uploads/img/pages/thumbnail/' .$page->cover_image_thumbnail)){
            //     unlink('../uploads/img/pages/thumbnail/' .$page->cover_image_thumbnail);
            // }
        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            http_response_code(500);
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            );
        }
    }
    public function publish()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE pages SET published = ? WHERE id = ?");
            $query->execute(array(1, $this->page->id));
            DatabaseController::disconnect();
            return (object)array(
                'status' => 1,
                'message' => 'Page published',
            );

        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            http_response_code(500);
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            );
        }
    }
    public function unpublish()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE pages SET published = ? WHERE id = ?");
            $query->execute(array(0, $this->page->id));
            DatabaseController::disconnect();
            return (object)array(
                'status' => 1,
                'message' => 'Page unpublished',
            );
        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            http_response_code(500);
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            );
        }
    }
    public static function getById($id)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM pages WHERE id = ?");
        $query->execute(array($id));
        DatabaseController::disconnect();
        return new Page((array) $query->fetch(PDO::FETCH_OBJ));
    }
    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM pages");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public static function getBySlug($slug, $section = null, $id = null)
    {
        $connection =  DatabaseController::connect();
        $statement = "SELECT * FROM pages WHERE slug = ?";
        $query_params = array($slug);
        if(isset($section)){
            $statement .= " AND section = ?";
            $query_params[] = $section;
        }
        if(isset($id)){
            $statement .= " AND id != ?";
            $query_params[] = $id;
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public static function getByUrl($url)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM pages WHERE url = ?");
        $query->execute(array($url));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT pages.*, users.username, DATE_FORMAT(pages.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(pages.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM pages LEFT JOIN users ON pages.author = users.id WHERE page_type IS NULL ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->datatable->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(pages.title LIKE ? OR pages.meta_description LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($this->data['order'])) {
            $order_col = $this->data['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'pages.title';
                    break;

                default:
                    $column = 'pages.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $this->data['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY pages.id DESC ";
        }
        if ($this->datatable->length != '-1') {
            $query .= 'LIMIT ' . $this->datatable->start . ', ' . $this->datatable->length;
        }
        $statement = $connection->prepare($query);
        $statement->execute($query_params);
         DatabaseController::disconnect();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        $data = array();
        foreach ($results as $row) {
            $table_row = array();
            $status = '<span class="badge bg-warning p-1 ms-2"> </span>';
            
            $publish_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-success btn-sm publish-page-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-check"></i></button>';
            $delete_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-danger btn-sm delete-page-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
            $view_btn = !$row->is_default ? '' : '<a href="'.WEBSITE .'/'.$row->url.'" target="_blank" class="btn btn-outline-secondary btn-sm view-page-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-eye"></i></a>';
            if($row->published){
                $status = '<span class="badge bg-success p-1 ms-2"> </span>';
                $publish_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-warning btn-sm unpublish-page-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-times"></i></button>';
            }

            $table_row[] = $row->title .$status;
            $table_row[] = $row->username;
            $table_row[] = $row->created_at;
            $table_row[] = $row->updated_at;
            $table_row[] = '<div class="btn-group">
                                    '.$publish_btn.'
                                    '.$view_btn.'
                                    <a href="'.DIRADMIN.'/pages/edit/'.HelperFunctions::encryptData($row->id).'" class="btn btn-outline-primary btn-sm edit-page-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-edit"></i></a>
                                    '.$delete_btn.'
                                </div>';

            $data[] = $table_row;
        }
        echo json_encode(array(
            "draw" => intval($this->datatable->draw),
            "recordsTotal" => count($results),
            "recordsFiltered" => $this->totalRecords(),
            "data" => $data
        ), JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES);
    }
    public function totalRecords()
    {
        $connection =  DatabaseController::connect();
        $statement = "SELECT COUNT(id) FROM pages ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->datatable->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(pages.title LIKE ? OR pages.meta_description LIKE ?) ";
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
        if (!file_exists('uploads/img/pages')) {
            mkdir('uploads/img/pages', 0777, true);
        }
        if (!file_exists('uploads/img/pages/thumbnails')) {
            mkdir('uploads/img/pages/thumbnails', 0777, true);
        }
        $dir = 'uploads/img/pages/';

        if ($this->data['tempFile']) {
            if (file_exists($this->data['tempFile'])) {
                list($img_width, $img_height) = getimagesize($this->data['tempFile']);
                $width = $img_width;
                $height = $img_height;
                $thumb_width = round($img_width/2);
                $thumb_height = round($img_height/2);

                $path_parts = pathinfo($this->data['tempFile']);
                $extension = $path_parts['extension'];
                $name_to_use = empty($this->page->slug) ? $this->page->title : $this->page->slug;
                $newfilename = strtolower($name_to_use . '-' . time() . '.' . $extension);
                $final_file = strtolower($name_to_use . '-' . time() . '.' . 'webp');
                rename($this->data['tempFile'], $dir . $newfilename);
                HelperFunctions::resize_image($dir . $newfilename, $dir.$newfilename, $width);
                HelperFunctions::resize_image($dir . $newfilename, $dir.'thumbnails/'.$newfilename, $thumb_width);
                HelperFunctions::webp_image($dir . $newfilename, $dir . $final_file, $width, $height, 85);
                HelperFunctions::webp_image($dir . 'thumbnails/' . $newfilename, $dir . 'thumbnails/' . $final_file, $thumb_width, $thumb_height, 85);
                if (file_exists($dir . $newfilename)) {
                    unlink($dir . $newfilename);
                }
                if (file_exists($dir . 'thumbnails/' . $newfilename)) {
                    unlink($dir . 'thumbnails/' . $newfilename);
                }
                // $this->cover_image = $dir . $final_file;
                // $this->cover_image_thumbnail = $dir . 'thumbnails/' . $final_file;

                $data = array(
                    'cover_image' => $dir . $final_file,
                    'cover_image_thumbnail' => $dir . 'thumbnails/' .$final_file
                );

                return $data;
            }
        }
    }
    public function uploadHeaderImage()
    {
        if (!file_exists('uploads/img')) {
            mkdir('uploads/img', 0777, true);
        }
        if (!file_exists('uploads/img/pages')) {
            mkdir('uploads/img/pages', 0777, true);
        }

        $dir = 'uploads/img/pages/';

        if ($this->data['tempHeaderFile']) {
            if (file_exists($this->data['tempHeaderFile'])) {
                list($img_width, $img_height) = getimagesize($this->data['tempHeaderFile']);
                $width = $img_width;
                $height = $img_height;

                $path_parts = pathinfo($this->data['tempHeaderFile']);
                $extension = $path_parts['extension'];
                $name_to_use = empty($this->page->slug) ? $this->page->title : $this->page->slug;
                $newfilename = strtolower($name_to_use . '-header-' . time() . '.' . $extension);
                $final_file = strtolower($name_to_use . '-header-' . time() . '.' . 'webp');
                rename($this->data['tempHeaderFile'], $dir . $newfilename);
                HelperFunctions::resize_image($dir . $newfilename, $dir.$newfilename, $width);
                HelperFunctions::webp_image($dir . $newfilename, $dir . $final_file, $width, $height, 85);
                if (file_exists($dir . $newfilename)) {
                    unlink($dir . $newfilename);
                }

                $data = array(
                    'header_image' => $dir . $final_file
                );

                return $data;
            }
        }
    }
}
