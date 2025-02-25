<?php

namespace App\Models;

class Email{
    public $id;
    public $recipient_name;
    public $recipient_email;
    public $subject;
    public $content_sections;
    public $message;
    public $send_date;
    public $status;
    
    public function __construct($data = array())
    {
        $this->id = $data['id'] ?? null;
        $this->recipient_name = $data['recipient_name'] ?? null;
        $this->recipient_email = $data['recipient_email'] ?? null;
        $this->subject = $data['subject'] ?? null;
        $this->content_sections = json_encode($data['content_sections']) ?? null;
        $this->message = $data['message'] ?? null;
        $this->send_date = $data['send_date'] ?? date('Y-m-d H:i:s');
        $this->status = $data['status'] ?? 'pending';
    }
}