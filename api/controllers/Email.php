<?php

include_once 'EmailInfobip.php';

class Email{
    public $id = null;
    public $salutation = null;
    public $recipient_name = null;
    public $recipient_email = null;
    public $cc = null;
    public $subject = null;
    public $body = null;
    public $attachment = null;
    public $content_sections = null;

    public function __construct($data = array()){
        if (isset($data['id']) && !empty($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['salutation']) && !empty($data['salutation'])) {
            $this->salutation = $data['salutation'];
        }
        if (isset($data['recipient_name']) && !empty($data['recipient_name'])) {
            $this->recipient_name = $data['recipient_name'];
        }
        if (isset($data['recipient_email']) && !empty($data['recipient_email'])) {
            $this->recipient_email = $data['recipient_email'];
        }
        if (isset($data['cc']) && !empty($data['cc'])) {
            $this->cc = $data['cc'];
        }
        if (isset($data['subject']) && !empty($data['subject'])) {
            $this->subject = $data['subject'];
        }
        if (isset($data['content_sections']) && !empty($data['content_sections'])) {
            $this->content_sections = $data['content_sections'];
        }
        if (isset($data['attachment']) && !empty($data['attachment'])) {
            $this->attachment = $data['attachment'];
        }
    }

    public function initializeParams($params){
        $this->__construct($params);
        $this->constructEmail();
    }

    public function send(){
        try {
            
        
        } 
        catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function constructEmail(){
        $template = Functions::readFileContents(DIR.MAIL_TEMPLATES.'default.php');

        $template = str_replace("%subject%", $this->subject, $template);
        $content = "";

        require_once '../'.MAIL_TEMPLATES.'mail_components.php';
        if(is_array($this->content_sections)){
            foreach($this->content_sections as $content_section){
                $component_template = $components[$content_section['type']];

                if($content_section['type'] == 'button'){
                    $component = str_replace('%link%', $content_section['link'], $component_template);
                    $component = str_replace("%action%", $content_section['action'], $component);
                }
                else{
                    $component = str_replace("%content%", $content_section['content'], $component_template);
                }
            
                $content .= $component;
            }
        }

        $this->body = str_replace("%content%", $content, $template);
    }
}