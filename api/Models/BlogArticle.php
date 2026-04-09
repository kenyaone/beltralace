<?php

namespace App\Models;

class BlogArticle extends Page
{
    public $author_name = null;
    public $is_featured = null;
    public $page_id = null;
    protected array $hidden = ['page_id'];

    public function __construct($data = array())
    {
        parent::__construct();
        $this->author_name = $data['author_name'] ?? null;
        $this->is_featured = $data['is_featured'] ?? null;
        $this->page_id = $data['page_id'] ?? null;
    }

    public function toArray()
    {
        $baseData = method_exists(parent::class, 'toArray') ? parent::toArray() : [];
        $props = get_object_vars($this);
    
        $merged = array_merge($baseData, $props);
    
        foreach ($this->hidden as $field) {
            unset($merged[$field]);
        }
    
        return $merged;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}