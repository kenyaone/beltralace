<?php

namespace App\Controllers;

use \PDO;
use \PDOException;

class FAQController
{
    public $id = null;
    public $question = null;
    public $answer = null;
    public $category = null;
    public $published = null;
    public $author = null;

    public $object = null;
    public $action = null;

    public $draw = null;
    public $columns = null;
    public $start = 0;
    public $length = null;
    public $search = null;
    public $order = null;

    public function __construct($data = array())
    {
        foreach (['id', 'question', 'answer', 'category', 'published', 'author', 'object', 'action', 'draw', 'columns', 'start', 'length', 'search', 'order'] as $field) {
            if (isset($data[$field]) && $data[$field] !== '') {
                $this->$field = $data[$field];
            }
        }
        if ($this->published === null) {
            $this->published = 0;
        }
    }

    public function initializeParams($params)
    {
        $this->__construct($params);
    }

    public function create()
    {
        $connection = DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO faqs(question, answer, category, published, author, created_at, updated_at) VALUES(?, ?, ?, ?, ?, NOW(), NOW())");
            $query->execute(array($this->question, $this->answer, $this->category, $this->published, $this->author));
            $this->id = $connection->lastInsertId();
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'FAQ created successfully',
                'id' => $this->id
            );
        } catch (PDOException $e) {
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
            $query = $connection->prepare("UPDATE faqs SET question = ?, answer = ?, category = ?, published = ?, author = ?, updated_at = NOW() WHERE id = ?");
            $query->execute(array($this->question, $this->answer, $this->category, $this->published, $this->author, $this->id));
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'FAQ updated successfully'
            );
        } catch (PDOException $e) {
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
            $query = $connection->prepare("DELETE FROM faqs WHERE id = ?");
            $query->execute(array($this->id));
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'FAQ deleted successfully',
                'id' => $this->id
            );
        } catch (PDOException $e) {
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage()
            );
        }
    }

    public static function getById($id)
    {
        $connection = DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM faqs WHERE id = ?");
        $query->execute(array($id));
        DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function getList()
    {
        $connection = DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM faqs ORDER BY category, id");
        $query->execute();
        DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getPublished()
    {
        $connection = DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM faqs WHERE published = 1 ORDER BY category, id");
        $query->execute();
        DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getPublishedGroupedByCategory()
    {
        $rows = self::getPublished();
        $grouped = array();
        foreach ($rows as $row) {
            $key = $row->category ?: 'Uncategorised';
            if (!isset($grouped[$key])) {
                $grouped[$key] = array();
            }
            $grouped[$key][] = $row;
        }
        return $grouped;
    }

    public function dataTable()
    {
        $connection = DatabaseController::connect();
        $query = "SELECT faqs.*, DATE_FORMAT(faqs.created_at, '%b %e, %Y %l:%i%p') AS created_at_fmt, DATE_FORMAT(faqs.updated_at, '%b %e, %Y %l:%i%p') AS updated_at_fmt FROM faqs ";
        $query_params = array();
        if (isset($this->search['value']) && $this->search['value'] !== '') {
            $query .= "WHERE (faqs.question LIKE ? OR faqs.answer LIKE ? OR faqs.category LIKE ?) ";
            $keyword = '%' . $this->search['value'] . '%';
            $query_params = array($keyword, $keyword, $keyword);
        }
        $query .= "ORDER BY faqs.category, faqs.id DESC ";
        if ($this->length !== null && $this->length != '-1') {
            $query .= 'LIMIT ' . intval($this->start) . ', ' . intval($this->length);
        }
        $statement = $connection->prepare($query);
        $statement->execute($query_params);
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        DatabaseController::disconnect();

        $data = array();
        foreach ($results as $row) {
            $publishedBadge = $row->published
                ? '<span class="badge bg-success">Published</span>'
                : '<span class="badge bg-secondary">Draft</span>';
            $data[] = array(
                htmlspecialchars($row->question, ENT_QUOTES),
                htmlspecialchars($row->category ?: '', ENT_QUOTES),
                $publishedBadge,
                $row->created_at_fmt,
                $row->updated_at_fmt,
                '<div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-sm edit-faq-btn" data-id="' . intval($row->id) . '"><i class="fas fa-fw fa-edit"></i></button>
                    <button type="button" class="btn btn-outline-danger btn-sm delete-faq-btn" data-id="' . intval($row->id) . '"><i class="fa fa-trash"></i></button>
                </div>'
            );
        }
        return json_encode(array(
            "draw" => intval($this->draw),
            "recordsTotal" => $this->totalRecords(),
            "recordsFiltered" => $this->totalRecords(),
            "data" => $data
        ), JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES);
    }

    public function totalRecords()
    {
        $connection = DatabaseController::connect();
        $query = $connection->prepare("SELECT COUNT(id) FROM faqs");
        $query->execute();
        DatabaseController::disconnect();
        return (int) $query->fetchColumn();
    }
}
