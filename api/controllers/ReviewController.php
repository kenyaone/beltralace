<?php

namespace App\Controllers;

use \PDO;
use \PDOException;
use App\Models\Review;
use App\Models\Datatable;
use App\Helpers\HelperFunctions;

class ReviewController
{
    public $review = null;
    public $datatable = null;
    public $data = null;


    public function __construct($data = array())
    {
        $this->review = new Review($data);
        $this->datatable = new Datatable($data);
        $this->data = $data;
    }

    public function create()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO reviews(name, email, review, is_published) VALUES(?, ?, ?, ?)");
            $query->execute(array($this->review->name, $this->review->email, $this->review->review, $this->review->is_published));
            $this->review->id = $connection->lastInsertId();
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'User review created',
                'data' => $this->review
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
            $query = $connection->prepare("UPDATE reviews SET name = ?, email = ?, review = ?, is_published = ?, author = ? WHERE id = ?");
            $query->execute(array($this->review->name, $this->review->email, $this->review->review, $this->review->is_published, $this->review->id));
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Review updated',
                'data' => $this->review
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
    public function delete()
    {
        $connection =  DatabaseController::connect();
        try {
            $inventory_category = self::getById($this->review->id);
            $query = $connection->prepare("DELETE FROM reviews WHERE id = ?");
            $query->execute(array($this->review->id));
             DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Review deleted',
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
        $query = $connection->prepare("SELECT * FROM reviews WHERE id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public static function getBySection($last_name)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM reviews WHERE last_name = ?");
        $query->execute(array($last_name));
        DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM reviews");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT reviews.*, users.username, DATE_FORMAT(reviews.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(reviews.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM reviews LEFT JOIN users ON reviews.author = users.id ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->datatable->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(reviews.first_name LIKE ? OR reviews.language LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($this->data['order'])) {
            $order_col = $this->data['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'reviews.first_name';
                    break;

                default:
                    $column = 'reviews.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $this->data['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY reviews.id DESC ";
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
            
            $publish_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-success btn-sm publish-review-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-check"></i></button>';
            $delete_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-danger btn-sm delete-review-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
            if($row->message){
                $status = '<span class="badge bg-success p-1 ms-2"> </span>';
                $publish_btn = $row->is_default ? '' : '<button type="button" class="btn btn-outline-warning btn-sm unpublish-review-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-times"></i></button>';
            }

            $table_row[] = HelperFunctions::limit_text($row->first_name, 5) ." ".$status;
            $table_row[] = $row->last_name;
            $table_row[] = $row->username;
            $table_row[] = $row->created_at;
            $table_row[] = $row->updated_at;
            $table_row[] = '<div class="btn-group">
                                    <a href="'.DIRADMIN.'/reviews/edit/'.HelperFunctions::encryptData($row->id).'" type="button" class="btn btn-outline-primary btn-sm edit-review-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-edit"></i></a>
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
        $statement = "SELECT COUNT(id) FROM reviews ";
        $query_params = array();
        $keyword = (isset($this->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(reviews.first_name LIKE ? OR reviews.language LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }
    public function getReviewFormEmailContent()
    {
        $email_body = array();
        $email_body[] = array(
            "type" => "body",
            "content" => 
                "
                <span>Name: ".$this->review->name."<span><br>
                <span>Email: ".$this->review->email."<span><br>
                <span>Review: ".$this->review->review."<span><br>
                "
        );
        return $email_body;
    }
    public function getReviewAcknowledgmentEmailContent()
    {
        $email_body = array();
        $email_body[] = array(
            "type" => "body",
            "content" => 
                "
                <p>Hi ".$this->review->name.",<p>
                <p>
                    Thank you for your feedback regarding our services. It helps us better our services as well as share success stories with other interested students.
                </p>
                "
        );


        // $email_body[] = array(
        //     "type" => "button",
        //     "link" => WEBSITE,
        //     "action" => "Click here to learn more"
        // );
        return $email_body;
    }
}
