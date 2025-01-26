<?php

namespace App\Models;
use App\Helpers\HelperFunctions;

class Page
{
    public $id = null;
    public $title = null;
    public $sub_title = 0;
    public $section = null;
    public $slug = null;
    public $url = null;
    public $page_type = null;
    public $meta_description = 0;
    public $body = null;
    public $cover_image = null;
    public $cover_image_thumbnail = null;
    public $header_image = null;
    public $published = 0;
    public $author = null;

    public function __construct($data = array())
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->sub_title = $data['sub_title'] ?? null;
        $this->section = $data['section'] ?? null;
        $this->slug = $data['slug'] ?? null;
        $this->url = (array_key_exists('section', $data) ? $data['section']."/" : "") .(array_key_exists('slug', $data) ? $data['slug'] : "");
        $this->page_type = $data['page_type'] ?? null;
        $this->meta_description = $data['meta_description'] ?? null;
        $this->body = $data['body'] ?? null;
        $this->cover_image = $data['cover_image'] ?? null;
        $this->cover_image_thumbnail = $data['cover_image_thumbnail'] ?? null;
        $this->header_image = $data['header_image'] ?? null;
        $this->published = $data['published'] ?? 0;
        $this->author = $data['author'] ?? null;

        if(array_key_exists('body', $data)){
            if(HelperFunctions::isBase64Encoded($data['body'])){
                $decoded_body = base64_decode($data['body']);
                $this->body = mb_convert_encoding($decoded_body, 'ISO-8859-1', 'UTF-8');
            }
            else{
                $this->body = $data['body'];
            }
        }
    }
}