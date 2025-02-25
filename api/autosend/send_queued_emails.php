<?php

require dirname(__DIR__) . "/config/config.php";

use App\Controllers\EmailQueueController;
use App\Middleware\EmailMiddleware;

try {
    $emails = EmailQueueController::getQueue();
    if (count($emails) > 0) {
        foreach ($emails as $email) {
            $email_data = [
                'recipient_name' => $email->recipient_name,
                'recipient_email' => $email->recipient_email,
                'subject' => $email->subject,
                'content_sections' => json_decode($email->content_sections),
                'message' => $email->message
            ];
            $email_obj = new EmailMiddleware($email_data);
            $response = $email_obj->send();

            $send_state = $response->status == 1 ? 'sent' : 'failed';
            $delivery_info = $response->message;

            EmailQueueController::dequeueSpecific($email->id, $send_state, $delivery_info);
        }
    } else {
        echo "No emails to send";
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
}
