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
        $connection = DatabaseController::connect();
        try {
            // Handle image upload (optional)
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = dirname(dirname(__DIR__)) . '/frontend/public/uploads/reviews/';
                
                // Create directory if it doesn't exist
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                $fileType = $_FILES['image']['type'];
                
                if (!in_array($fileType, $allowedTypes)) {
                    throw new \Exception('Only JPG, PNG, and WEBP images are allowed');
                }
                
                // Validate file size (max 5MB)
                if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                    throw new \Exception('Image size must be less than 5MB');
                }
                
                // Generate unique filename
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('review_') . '_' . time() . '.' . $extension;
                $targetPath = $uploadDir . $filename;
                
                // Move uploaded file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imagePath = 'uploads/reviews/' . $filename;
                    $this->review->image_path = $imagePath;
                }
            }

            $query = $connection->prepare("INSERT INTO reviews(name, email, review, rating, image_path, is_published, created_at, updated_at) VALUES(?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $query->execute(array(
                $this->review->name, 
                $this->review->email, 
                $this->review->review,
                $this->review->rating,
                $this->review->image_path,
                $this->review->is_published
            ));
            $this->review->id = $connection->lastInsertId();
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Thank you for your review! It will be published after admin approval.',
                'data' => $this->review
            );

        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            return (object) array(
                'status' => 0,
                'message' => DEBUG_MODE ? $e->getMessage() : 'Failed to submit review. Please try again.'
            );
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage()
            );
        }
    }

    public function update()
    {
        $connection = DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE reviews SET name = ?, email = ?, review = ?, rating = ?, image_path = ?, is_published = ?, updated_at = NOW() WHERE id = ?");
            $query->execute(array(
                $this->review->name, 
                $this->review->email, 
                $this->review->review,
                $this->review->rating,
                $this->review->image_path,
                $this->review->is_published, 
                $this->review->id
            ));
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Review updated',
                'data' => $this->review
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

    public function approve()
    {
        $connection = DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE reviews SET is_published = 1, updated_at = NOW() WHERE id = ?");
            $query->execute(array($this->review->id));
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Review published successfully'
            );
        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage()
            );
        }
    }

    public function unpublish()
    {
        $connection = DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE reviews SET is_published = 0, updated_at = NOW() WHERE id = ?");
            $query->execute(array($this->review->id));
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Review unpublished successfully'
            );
        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage()
            );
        }
    }

    public function delete()
    {
        $connection = DatabaseController::connect();
        try {
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
        $connection = DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM reviews WHERE id = ?");
        $query->execute(array($id));
        DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getPublished()
    {
        $connection = DatabaseController::connect();
        $query = $connection->prepare("SELECT id, name, review, rating, image_path, created_at FROM reviews WHERE is_published = 1 ORDER BY created_at DESC");
        $query->execute();
        DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getList()
    {
        $connection = DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM reviews ORDER BY created_at DESC");
        $query->execute();
        DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function dataTable()
    {
        $connection = DatabaseController::connect();
        $query = "SELECT reviews.*, DATE_FORMAT(reviews.created_at, '%b %e, %Y %l:%i%p') AS created_at_formatted, DATE_FORMAT(reviews.updated_at, '%b %e, %Y %l:%i%p') AS updated_at_formatted FROM reviews ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        
        if (isset($this->datatable->search['value'])) {
            $query .= "WHERE (reviews.name LIKE ? OR reviews.email LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        
        if (isset($this->data['order'])) {
            $order_col = $this->data['order']['0']['column'];
            $column = 'reviews.id';
            switch ($order_col) {
                case 0:
                    $column = 'reviews.name';
                    break;
                case 1:
                    $column = 'reviews.is_published';
                    break;
                case 2:
                    $column = 'reviews.created_at';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $this->data['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY reviews.is_published ASC, reviews.created_at DESC ";
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
            $status = $row->is_published ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-warning">Pending</span>';
            
            $stars = str_repeat('★', intval($row->rating)) . str_repeat('☆', 5 - intval($row->rating));
            
            $approve_btn = $row->is_published ? 
                '<button type="button" class="btn btn-outline-warning btn-sm unpublish-review-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-times"></i></button>' : 
                '<button type="button" class="btn btn-outline-success btn-sm approve-review-btn" data-id="'. $row->id . '"><i class="fas fa-fw fa-check"></i></button>';
            
            $delete_btn = '<button type="button" class="btn btn-outline-danger btn-sm delete-review-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';

            $table_row[] = htmlspecialchars($row->name);
            $table_row[] = htmlspecialchars($row->email ?: '—');
            $table_row[] = $stars;
            $table_row[] = HelperFunctions::limit_text($row->review, 15);
            $table_row[] = $status;
            $table_row[] = $row->created_at_formatted;
            $table_row[] = '<div class="btn-group">' . $approve_btn . $delete_btn . '</div>';

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
        $connection = DatabaseController::connect();
        $statement = "SELECT COUNT(id) FROM reviews ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        
        if (isset($this->datatable->search['value'])) {
            $statement .= "WHERE (reviews.name LIKE ? OR reviews.email LIKE ?) ";
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
        $stars = str_repeat('★', intval($this->review->rating)) . str_repeat('☆', 5 - intval($this->review->rating));
        
        $email_body = array();
        $email_body[] = array(
            "type" => "body",
            "content" =>
                "
                <span>Name: ".$this->review->name."<span><br>
                <span>Email: ".$this->review->email."<span><br>
                <span>Rating: ".$stars."<span><br>
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
                    Thank you for your feedback regarding our services. Your review will be published after admin approval. It helps us better our services as well as share success stories with other interested students.
                </p>
                "
        );
        return $email_body;
    }
}
