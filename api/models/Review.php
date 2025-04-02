<?php

namespace App\Models;
use App\Helpers\HelperFunctions;

class Review
{
    public $id = null;
    public $name = null;
    public $email = null;
    public $review = null;
    public $is_published = null;

    public function __construct($data = array())
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->review = $data['review'] ?? null;
        $this->is_published = $data['is_published'] ?? 0;
    }
}