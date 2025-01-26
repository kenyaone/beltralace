<?php

namespace App\Controllers;

use \PDO;
use \PDOException;
use App\Models\BlogArticle;
use App\Models\Datatable;
use App\Helpers\HelperFunctions;
class BlogArticleController
{
    public $blog_article = null;
    public $datatable = null;
    public $data = null;
    public function __construct($data = array())
    {
        $this->blog_article = new BlogArticle($data);
        $this->datatable = new Datatable($data);
        $this->data = $data;
    }
    public function create ()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO blog_articles(author_name, page_id) VALUES(?, ?)");
            $query->execute(array($this->blog_article->author_name, $this->blog_article->page_id));
            $this->blog_article->id = $connection->lastInsertId();
             DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Article created'
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

    public function update ()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE blog_articles SET author_name = ?, is_featured = ? WHERE id = ?");
            $query->execute(array($this->blog_article->author_name, $this->blog_article->is_featured, $this->blog_article->id));
             DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Article updated'
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
        $query = $connection->prepare("SELECT pages.title, pages.slug, pages.url, pages.meta_description, pages.body, pages.cover_image, pages.cover_image_thumbnail, pages.header_image, pages.published, blog_articles.* FROM blog_articles LEFT JOIN pages ON blog_articles.page_id = pages.id WHERE blog_articles.id = ?");
        $query->execute(array($id));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public static function getByPage($page_id)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT blog_articles.*, DATE_FORMAT(blog_articles.created_at, '%b %e, %Y') AS authored_on WHERE blog_articles.page_id = ?");
        $query->execute(array($page_id));
        DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getFeaturedProduct()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT pages.title, pages.slug, pages.url, pages.meta_description, pages.body, pages.cover_image, pages.cover_image_thumbnail, pages.header_image, pages.published, blog_articles.* FROM blog_articles LEFT JOIN pages ON blog_articles.page_id = pages.id WHERE blog_articles.is_featured = ?");
        $query->execute(array(1));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM blog_articles");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getLatest()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT blog_articles.*, pages.*, users.username AS author, DATE_FORMAT(blog_articles.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(blog_articles.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM blog_articles 
            LEFT JOIN pages ON blog_articles.page_id = pages.id
            LEFT JOIN users ON pages.author = users.id
            WHERE pages.published = ? ORDER BY blog_articles.id DESC");
        $query->execute(array(1));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getPublished()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT blog_articles.*, pages.*, users.username AS author, DATE_FORMAT(blog_articles.created_at, '%b %e, %Y') AS created_at, DATE_FORMAT(blog_articles.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM blog_articles 
            LEFT JOIN pages ON blog_articles.page_id = pages.id
            LEFT JOIN users ON pages.author = users.id
            WHERE pages.published = ? ORDER BY RAND ()");
        $query->execute(array(1));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT blog_articles.*, pages.title, pages.slug, pages.body, pages.cover_image_thumbnail, users.username, DATE_FORMAT(blog_articles.created_at, '%b %e, %Y %l:%i%p') AS created_at, DATE_FORMAT(blog_articles.updated_at, '%b %e, %Y %l:%i%p') AS updated_at FROM blog_articles 
            LEFT JOIN pages ON blog_articles.page_id = pages.id
            LEFT JOIN users ON pages.author = users.id ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->datatable->search['value'])) {
            if (strpos($query, "WHERE") !== false) {
                $query .= "AND ";
            } else {
                $query .= "WHERE ";
            }
            $query .= "(blog_articles.page_id LIKE ? OR pages.body LIKE ?) ";
            for ($i = 0; $i < 2; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($this->data['order'])) {
            $order_col = $this->data['order']['0']['column'];
            $column = '';
            switch ($order_col) {
                case 0:
                    $column = 'blog_articles.page_id';
                    break;

                default:
                    $column = 'blog_articles.id';
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $this->data['order']['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY blog_articles.id DESC ";
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
            $thumbnail = "https://wellsaidlabs.com/wp-content/uploads/2023/09/blog_header_custom-voice-768x432.jpg";
            $table_row = array();
            $table_row[] = '<img src="'.$thumbnail.'" class="img-fluid img-thumbnail" style="height: 40px"/>';
            $table_row[] = $row->title;
            $table_row[] = $row->username;
            $table_row[] = $row->created_at;
            $table_row[] = $row->updated_at;
            $table_row[] = '<div class="btn-group">
                                    <a href="'.WEBSITE .'/blogs/'.$row->slug.'" target="_blank" class="btn btn-outline-secondary btn-sm view-page-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-eye"></i></a>
                                    <a href="'.DIRADMIN .'/blog-articles/edit/'.HelperFunctions::encryptData($row->id).'" class="btn btn-outline-primary btn-sm edit-blog-article-btn" data-id="' . $row->id . '"><i class="fas fa-fw fa-edit"></i></a>
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-blog-article-btn" data-id="' . $row->page_id . '"><i class="fa fa-trash"></i></button>
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
        $statement = "SELECT COUNT(blog_articles.id) FROM blog_articles 
            LEFT JOIN pages ON blog_articles.page_id = pages.id ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->datatable->search['value'])) {
            if (strpos($statement, "WHERE") !== false) {
                $statement .= "AND ";
            } else {
                $statement .= "WHERE ";
            }
            $statement .= "(blog_articles.page_id LIKE ? OR pages.body LIKE ?) ";
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
