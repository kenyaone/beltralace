<?php

namespace App\Controllers;

use \PDO;
use \PDOException;
use App\Models\Enquiry;
use App\Models\Datatable;
use App\Helpers\HelperFunctions;

class EnquiryController
{
    public $enquiry = null;
    public $datatable = null;
    public $data = null;


    public function __construct($data = array())
    {
        $this->enquiry = new Enquiry($data);
        $this->datatable = new Datatable($data);
        $this->data = $data;
    }

    public function create()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO enquiries(first_name, middle_name, last_name, language, subject, message) VALUES(?, ?, ?, ?, ?, ?)");
            $query->execute(array($this->enquiry->first_name, $this->enquiry->middle_name, $this->enquiry->last_name, $this->enquiry->language, $this->enquiry->subject, $this->enquiry->message));
            $this->enquiry->id = $connection->lastInsertId();
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Enquiry created',
                'data' => $this->enquiry
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
            $query = $connection->prepare("UPDATE enquiries SET first_name = ?, middle_name = ?, language = ?, subject = ?, message = ?, author = ? WHERE id = ?");
            $query->execute(array($this->enquiry->first_name, $this->enquiry->middle_name, $this->enquiry->language, $this->enquiry->subject, $this->enquiry->message, $this->enquiry->author, $this->enquiry->id));
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Enquiry updated',
                'data' => $this->enquiry
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
            $query = $connection->prepare("UPDATE enquiries SET subject = ? WHERE id = ?");
            $query->execute(array($data['subject'], $data['id']));
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
            $inventory_category = self::getById($this->enquiry->id);
            $query = $connection->prepare("DELETE FROM enquiries WHERE id = ?");
            $query->execute(array($this->enquiry->id));
             DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Enquiry deleted',
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
    //         $inventory_category = Enquiry::getById($this->id);
    //         $query = $connection->prepare("UPDATE enquiries SET message = ? WHERE id = ?");
    //         $query->execute(array(1, $this->id));
    //          DatabaseController::disconnect();
    //         echo json_encode(array(
    //             'status' => 1,
    //             'message' => 'Enquiry message successfully',
    //             'id' => $this->id
    //         ));

    //         if ($this->id) {
    //             $data = array(
    //                 "user_id" => $this->author,
    //                 "first_name" => "Enquiry message",
    //                 "description" => "Published enquiry: '" . $inventory_category->first_name . "' - '" . $inventory_category->language . "'",
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
    //         $query = $connection->prepare("UPDATE enquiries SET message = ? WHERE id = ?");
    //         $query->execute(array(0, $this->id));
    //          DatabaseController::disconnect();
    //         echo json_encode(array(
    //             'status' => 1,
    //             'message' => 'Enquiry unpublished successfully',
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
        $query = $connection->prepare("SELECT * FROM enquiries WHERE id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public static function getBySection($last_name)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM enquiries WHERE last_name = ?");
        $query->execute(array($last_name));
        DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM enquiries");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT enquiries.*, users.username, DATE_FORMAT(enquiries.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(enquiries.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM enquiries LEFT JOIN users ON enquiries.author = users.id ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->datatable->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(enquiries.first_name LIKE ? OR enquiries.language LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($this->data['order'])) {
            $order_col = $this->data['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'enquiries.first_name';
                    break;

                default:
                    $column = 'enquiries.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $this->data['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY enquiries.id DESC ";
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
            
            $publish_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-success btn-sm publish-enquiry-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-check"></i></button>';
            $delete_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-danger btn-sm delete-enquiry-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
            if($row->message){
                $status = '<span class="badge bg-success p-1 ms-2"> </span>';
                $publish_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-warning btn-sm unpublish-enquiry-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-times"></i></button>';
            }

            $table_row[] = HelperFunctions::limit_text($row->first_name, 5) ." ".$status;
            $table_row[] = $row->last_name;
            $table_row[] = $row->username;
            $table_row[] = $row->created_at;
            $table_row[] = $row->updated_at;
            $table_row[] = '<div class="btn-group">
                                    <a href="'.DIRADMIN.'/enquiries/edit/'.HelperFunctions::encryptData($row->id).'" type="button" class="btn btn-outline-primary btn-sm edit-enquiry-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-edit"></i></a>
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
        $statement = "SELECT COUNT(id) FROM enquiries ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(enquiries.first_name LIKE ? OR enquiries.language LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }

    // public function uploadEnquiryImage()
    // {
    //     if (!file_exists('../uploads/img')) {
    //         mkdir('../uploads/img', 0777, true);
    //     }
    //     if (!file_exists('../uploads/img/enquiries')) {
    //         mkdir('../uploads/img/enquiries', 0777, true);
    //     }

    //     $dir = 'uploads/img/enquiries/';

    //     if ($this->tempFile) {
    //         if (file_exists('../' . $this->tempFile)) {
    //             list($img_width, $img_height) = getimagesize('../' . $this->tempFile);
    //             $width = $img_width;
    //             $height = $img_height;
    //             $thumb_width = round($img_width/2);
    //             $thumb_height = round($img_height/2);

    //             $path_parts = pathinfo('../' . $this->tempFile);
    //             $extension = $path_parts['extension'];
    //             $newfilename = strtolower($this->last_name . '-' . time() . '.' . $extension);
    //             $final_file = strtolower($this->last_name . '-' . time() . '.' . 'webp');
    //             rename('../' . $this->tempFile, '../' . $dir . $newfilename);
    //             HelperFunctions::resize_image('../' . $dir . $newfilename, '../'.$dir.$newfilename, $width);
    //             HelperFunctions::webp_image('../' . $dir . $newfilename, '../' . $dir . $final_file, $width, $height, 85);
    //             if (file_exists('../' . $dir . $newfilename)) {
    //                 unlink('../' . $dir . $newfilename);
    //             }
    //             $this->subject = $dir . $final_file;
    //         }
    //     }
    // }

    public function uploadImage()
    {
        if (!file_exists('uploads/img/enquiries')) {
            mkdir('uploads/img/enquiries', 0777, true);
        }
        $dir = 'uploads/img/enquiries/';

        if ($this->data['tempFile']) {
            if (file_exists($this->data['tempFile'])) {
                list($img_width, $img_height) = getimagesize($this->data['tempFile']);
                $width = $img_width;
                $height = $img_height;

                $path_parts = pathinfo($this->data['tempFile']);
                $extension = $path_parts['extension'];
                $name_to_use = str_replace([" ", ","], "-", $this->enquiry->first_name);
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
                    'subject' => $dir . $final_file
                );

                return $data;
            }
        }
    }
}
