<?php

namespace App\Middleware;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use App\Helpers\HelperFunctions;

class EmailMiddleware{
    public $id = null;
    public $salutation = null;
    public $recipient_name = null;
    public $recipient_email = null;
    public $cc = null;
    public $subject = null;
    public $message = null;
    public $attachment = null;
    public $content_sections = null;

    public function __construct($data = array()){
        if (isset($data['id']) && !empty($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['salutation']) && !empty($data['salutation'])) {
            $this->salutation = $data['salutation'];
        }
        if (isset($data['subject']) && !empty($data['subject'])) {
            $this->subject = $data['subject'];
        }
        if (isset($data['message']) && !empty($data['message'])) {
            $this->message = $data['message'];
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
        if (isset($data['content_sections']) && !empty($data['content_sections'])) {
            $this->content_sections = $data['content_sections'];
        }
        if (isset($data['attachment']) && !empty($data['attachment'])) {
            $this->attachment = $data['attachment'];
        }

        $this->constructEmail();
    }


    public function send(){
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = EMAIL_DEBUG_MODE ? SMTP::DEBUG_SERVER : false;    
            $mail->isSMTP();                                      
            $mail->Host       = EMAIL_HOST;                    
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'tls';           
            $mail->Port       = 587;  
            $mail->isHTML(true);
        
            $mail->Username = EMAIL; // SMTP username
            $mail->Password = EMAIL_PASSWORD; // SMTP password
            $mail->setFrom(EMAIL, SITETITLE);  
            $mail->addAddress($this->recipient_email, $this->recipient_name);
            if($this->recipient_email == ADMIN_EMAIL){
                $mail->addCC("info@beltralace.com");
            }
            $mail->Subject = $this->subject;
            $mail->Body= $this->message;
            $mail->send();
            return (object) [
                'status' => 1,
                'message' => 'Email sent successfully'
            ];
        } 
        catch (\Exception $e) {
            error_log("Email failed. Mailer Error: {$mail->ErrorInfo}");
            return (object) [
                'status' => 0,
                'message' => $mail->ErrorInfo
            ];
        }
    }

    public function constructEmail(){
        $template = HelperFunctions::readFileContents(DIR . MAIL_TEMPLATES . 'default.php');

        $template = str_replace("%subject%", $this->subject, $template);
        $content = "";

        require dirname(__DIR__) . "/" . MAIL_TEMPLATES . 'mail_components.php';
        if(is_array($this->content_sections)){
            foreach($this->content_sections as $content_section){
                $content_section = (array) $content_section;

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

            $this->message = str_replace("%content%", $content, $template);
        }
    }
}