<?php

namespace App\Models;
use App\Helpers\HelperFunctions;

class Review
{
    public $id = null;
    public $name = null;
    public $email = null;
    public $review = null;
    public $rating = null;
    public $image_path = null;
    public $is_published = null;

    public function __construct($data = array())
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->review = $data['review'] ?? null;
        $this->rating = $data['rating'] ?? 5;
        $this->image_path = $data['image_path'] ?? null;
        $this->is_published = $data['is_published'] ?? 0;
    }
}
