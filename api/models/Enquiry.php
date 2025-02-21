<?php

namespace App\Models;
use App\Helpers\HelperFunctions;

class Enquiry
{
    public $id = null;
    public $first_name = null;
    public $middle_name = null;
    public $last_name = null;
    public $language = null;
    public $subject = null;
    public $message = null;
    public $author = null;

    public function __construct($data = array())
    {
        $this->id = $data['id'] ?? null;
        $this->first_name = $data['first_name'] ?? null;
        $this->middle_name = $data['middle_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->language = $data['language'] ?? null;
        $this->message = $data['message'] ?? 0;
    }
}