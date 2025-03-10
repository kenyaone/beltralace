<?php

namespace App\Models;
use App\Helpers\HelperFunctions;

class Enquiry
{
    public $id = null;
    public $first_name = null;
    public $middle_name = null;
    public $last_name = null;
    public $name = null;
    public $email = null;
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
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->language = $data['language'] ?? null;
        $this->subject = $data['subject'] ?? null;
        $this->message = $data['message'] ?? null;
    }
}