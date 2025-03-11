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
            $query = $connection->prepare("INSERT INTO enquiries(first_name, middle_name, last_name, name, email, phone, address, town, country, nationality, native_language, language, subject, message) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->execute(array($this->enquiry->first_name, $this->enquiry->middle_name, $this->enquiry->last_name, $this->enquiry->name, $this->enquiry->email, $this->enquiry->phone, $this->enquiry->address, $this->enquiry->town, $this->enquiry->country, $this->enquiry->nationality, $this->enquiry->native_language, $this->enquiry->language, $this->enquiry->subject, $this->enquiry->message));
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
    public function getCtaEmailContent()
    {
        $email_body = array();
        $email_body[] = array(
            "type" => "body",
            "content" => 
                "
                <span>First name: ".$this->enquiry->first_name."<span><br>
                <span>Middle name: ".$this->enquiry->middle_name."<span><br>
                <span>Last name: ".$this->enquiry->last_name."<span><br>
                <span>Email: ".$this->enquiry->email."<span><br>
                <span>Language: ".$this->enquiry->language."<span><br>
                <span>Message: ".$this->enquiry->message."<span><br>
                "
        );
        return $email_body;
    }
    public function getContactFormEmailContent()
    {
        $email_body = array();
        $email_body[] = array(
            "type" => "body",
            "content" => 
                "
                <span>Name: ".$this->enquiry->name."<span><br>
                <span>Email: ".$this->enquiry->email."<span><br>
                <span>Subject: ".$this->enquiry->subject."<span><br>
                <span>Message: ".$this->enquiry->message."<span><br>
                "
        );
        return $email_body;
    }
    public function getJobApplicationEmailContent()
    {
        $email_body = array();
        $email_body[] = array(
            "type" => "body",
            "content" => 
                "
                <span>First name: ".$this->enquiry->first_name."<span><br>
                <span>Middle name: ".$this->enquiry->middle_name."<span><br>
                <span>Last name: ".$this->enquiry->last_name."<span><br>
                <span>Email: ".$this->enquiry->email."<span><br>
                <span>Phone: ".$this->enquiry->phone."<span><br>
                <span>Native Language: ".$this->enquiry->native_language."<span><br>
                <span>Nationality: ".$this->enquiry->nationality."<span><br>
                "
        );
        return $email_body;
    }
    public function getAcknowledgmentEmailContent()
    {
        $email_body = array();
        $email_body[] = array(
            "type" => "body",
            "content" => 
                "
                <p>Hi ".$this->enquiry->first_name.",<p>
                <p>
                    Thank you for expressing interest in learning ".$this->enquiry->language.". One of our team members will get back to you shortly with more details.
                </p>
                "
        );

        $email_body[] = array(
            "type" => "more_details",
            "content" => 
                "
                <p>
                    <i>'Language is the bridge that links people of different nations. A friend afar brings a distant land near!'</i>
                </p>
                "
        );

        $email_body[] = array(
            "type" => "button",
            "link" => WEBSITE,
            "action" => "Click here to learn more"
        );
        return $email_body;
    }
    public function getContactAcknowledgmentEmailContent()
    {
        $email_body = array();
        $email_body[] = array(
            "type" => "body",
            "content" => 
                "
                <p>Hi ".$this->enquiry->name.",<p>
                <p>
                    Thank you for your email. One of our team members will get back to you shortly with more details on your enquiry.
                </p>
                "
        );

        $email_body[] = array(
            "type" => "more_details",
            "content" => 
                "
                <p>
                    <i>'Language is the bridge that links people of different nations. A friend afar brings a distant land near!'</i>
                </p>
                "
        );

        $email_body[] = array(
            "type" => "button",
            "link" => WEBSITE,
            "action" => "Click here to learn more"
        );
        return $email_body;
    }
    public function getAppplicationAcknowledgmentEmailContent()
    {
        $email_body = array();
        $email_body[] = array(
            "type" => "body",
            "content" => 
                "
                <p>Hi ".$this->enquiry->first_name.",<p>
                <p>
                    Thank you for expressing interest in becoming a trainer. One of our team members will get back to you shortly with more details.
                </p>
                "
        );

        $email_body[] = array(
            "type" => "more_details",
            "content" => 
                "
                <p>
                    <i>'Language is the bridge that links people of different nations. A friend afar brings a distant land near!'</i>
                </p>
                "
        );

        $email_body[] = array(
            "type" => "button",
            "link" => WEBSITE,
            "action" => "Click here to learn more"
        );
        return $email_body;
    }
}
