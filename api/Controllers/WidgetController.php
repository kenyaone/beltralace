<?php

namespace App\Controllers;

use \PDO;
use \PDOException;
use App\Models\Widget;
use App\Models\Datatable;
use App\Helpers\HelperFunctions;

class WidgetController
{
    public $widget = null;
    public $datatable = null;
    public $data = null;


    public function __construct($data = array())
    {
        $this->widget = new Widget($data);
        $this->datatable = new Datatable($data);
        $this->data = $data;
    }

    public function create()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO widgets(title, sub_title, section, body, published, author) VALUES(?, ?, ?, ?, ?, ?)");
            $query->execute(array($this->widget->title, $this->widget->sub_title, $this->widget->section, $this->widget->body, $this->widget->published, $this->widget->author));
            $this->widget->id = $connection->lastInsertId();
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Widget created',
                'data' => $this->widget
            );

        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            ));
        }
    }

    public function update()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE widgets SET title = ?, sub_title = ?, body = ?, published = ?, author = ? WHERE id = ?");
            $query->execute(array($this->widget->title, $this->widget->sub_title, $this->widget->body, $this->widget->published, $this->widget->author, $this->widget->id));
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Widget updated',
                'data' => $this->widget
            );

        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            http_response_code(500);
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            ));
        }
    }
    public static function updateImage($data)
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE widgets SET image = ? WHERE id = ?");
            $query->execute(array($data['image'], $data['id']));
             DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Image updated',
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
            $inventory_category = self::getById($this->widget->id);
            $query = $connection->prepare("DELETE FROM widgets WHERE id = ?");
            $query->execute(array($this->widget->id));
             DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Widget deleted',
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

    // public function publish()
    // {
    //     $connection =  DatabaseController::connect();
    //     try {
    //         $inventory_category = Widget::getById($this->id);
    //         $query = $connection->prepare("UPDATE widgets SET published = ? WHERE id = ?");
    //         $query->execute(array(1, $this->id));
    //          DatabaseController::disconnect();
    //         echo json_encode(array(
    //             'status' => 1,
    //             'message' => 'Widget published successfully',
    //             'id' => $this->id
    //         ));

    //         if ($this->id) {
    //             $data = array(
    //                 "user_id" => $this->author,
    //                 "title" => "Widget published",
    //                 "description" => "Published widget: '" . $inventory_category->title . "' - '" . $inventory_category->body . "'",
    //                 "object" => $this->object,
    //                 "item_id" => $this->id,
    //             );
    //             $transaction_log = new UserTransactionLog();
    //             $transaction_log->initializeParams($data);
    //             $transaction_log->create();
    //         }
    //     } catch (PDOException $e) {
    //         echo json_encode(array(
    //             'status' => 0,
    //             'message' => $e->getMessage()
    //         ));
    //     }
    // }
    // public function unpublish()
    // {
    //     $connection =  DatabaseController::connect();
    //     try {
    //         $inventory_category = self::getById($this->id);
    //         $query = $connection->prepare("UPDATE widgets SET published = ? WHERE id = ?");
    //         $query->execute(array(0, $this->id));
    //          DatabaseController::disconnect();
    //         echo json_encode(array(
    //             'status' => 1,
    //             'message' => 'Widget unpublished successfully',
    //             'id' => $this->id
    //         ));

    //     } catch (PDOException $e) {
    //         echo json_encode(array(
    //             'status' => 0,
    //             'message' => $e->getMessage()
    //         ));
    //     }
    // }
    public static function getById($id)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM widgets WHERE id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public static function getBySection($section)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM widgets WHERE section = ?");
        $query->execute(array($section));
        DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public static function getByTitle($title)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM widgets WHERE title = ? LIMIT 1");
        $query->execute(array($title));
        DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM widgets");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT widgets.*, users.username, DATE_FORMAT(widgets.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(widgets.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM widgets LEFT JOIN users ON widgets.author = users.id ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->datatable->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(widgets.title LIKE ? OR widgets.body LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($this->data['order'])) {
            $order_col = $this->data['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'widgets.title';
                    break;

                default:
                    $column = 'widgets.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $this->data['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY widgets.id DESC ";
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
            
            $publish_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-success btn-sm publish-widget-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-check"></i></button>';
            $delete_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-danger btn-sm delete-widget-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
            if($row->published){
                $status = '<span class="badge bg-success p-1 ms-2"> </span>';
                $publish_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-warning btn-sm unpublish-widget-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-times"></i></button>';
            }

            $table_row[] = HelperFunctions::limit_text($row->title, 5) ." ".$status;
            $table_row[] = $row->section;
            $table_row[] = $row->username;
            $table_row[] = $row->created_at;
            $table_row[] = $row->updated_at;
            $table_row[] = '<div class="btn-group">
                                    <a href="'.DIRADMIN.'/widgets/edit/'.HelperFunctions::encryptData($row->id).'" type="button" class="btn btn-outline-primary btn-sm edit-widget-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-edit"></i></a>
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
        $statement = "SELECT COUNT(id) FROM widgets ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(widgets.title LIKE ? OR widgets.body LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }

    public function uploadImage()
    {
        if (!file_exists('uploads/img/widgets')) {
            mkdir('uploads/img/widgets', 0777, true);
        }
        $dir = 'uploads/img/widgets/';

        if ($this->data['tempFile']) {
            if (file_exists($this->data['tempFile'])) {
                list($img_width, $img_height) = getimagesize($this->data['tempFile']);
                $width = $img_width;
                $height = $img_height;

                $path_parts = pathinfo($this->data['tempFile']);
                $extension = $path_parts['extension'];
                $name_to_use = str_replace([" ", ","], "-", $this->widget->title);
                $name_to_use = str_replace("--", "-", $name_to_use);
                $newfilename = strtolower( $name_to_use . '-' . time() . '.' . $extension);
                $final_file = strtolower($name_to_use . '-' . time() . '.' . 'webp');
                rename($this->data['tempFile'], $dir . $newfilename);
                HelperFunctions::resize_image($dir . $newfilename, $dir.$newfilename, $width);
                HelperFunctions::webp_image($dir . $newfilename, $dir . $final_file, $width, $height, 85);
                if (file_exists($dir . $newfilename)) {
                    unlink($dir . $newfilename);
                }
                $data = array(
                    'image' => $dir . $final_file
                );

                return $data;
            }
        }
    }
}
