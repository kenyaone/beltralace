<?php

namespace App\Models;
use App\Helpers\HelperFunctions;

class Widget
{
    public $id = null;
    public $title = null;
    public $sub_title = null;
    public $section = null;
    public $body = null;
    public $image = null;
    public $published = 0;
    public $author = null;

    public function __construct($data = array())
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->sub_title = $data['sub_title'] ?? null;
        $this->section = $data['section'] ?? null;
        $this->body = $data['body'] ?? null;
        $this->published = $data['published'] ?? 0;
        $this->author = $data['author'] ?? null;

        if(array_key_exists('body', $data)){
            if(HelperFunctions::isBase64Encoded($data['body'])){
                $this->body = base64_decode($data['body']);
            }
            else{
                $this->body = $data['body'];
            }
        }

    }
}