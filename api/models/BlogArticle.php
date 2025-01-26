<?php

namespace App\Models;

class BlogArticle extends Page
{
    public $author_name = null;
    public $is_featured = null;
    public $page_id = null;

    public function __construct($data = array())
    {
        parent::__construct();
        $this->author_name = $data['author_name'] ?? null;
        $this->is_featured = $data['is_featured'] ?? null;
        $this->page_id = $data['page_id'] ?? null;
    }
}