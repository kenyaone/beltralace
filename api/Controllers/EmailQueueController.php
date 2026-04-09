<?php

namespace App\Controllers;

use \PDO;
use \PDOException;
use App\Models\Email;

class EmailQueueController{
    public $email = null;

    public function __construct($data = array()){
        $this->email = new Email($data);
    }
    public function enqueue()
    {
        try{
            $connection = DatabaseController::connect();
            $query = $connection->prepare("INSERT INTO email_queue (recipient_name, recipient_email, subject, content_sections, message, send_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $query->execute(array($this->email->recipient_name, $this->email->recipient_email, $this->email->subject, $this->email->content_sections, $this->email->message, $this->email->send_date, $this->email->status));
            $connection = null;

            return array(
                'status' => 1,
                'message' => 'Email queued',
            );
        }
        catch (PDOException $e) {
            http_response_code(500);
            return array(
                'status' => 0,
                'message' => $e->getMessage()
            );
        } 
    }
    public static function dequeueSpecific($id, $send_state = 'sent', $delivery_info = 'Email sent successfully')
    {
        $connection = DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE email_queue SET send_date = ?, status = ?, delivery_info = ? WHERE id = ?");
            $query->execute(array(date('Y-m-d H:i:s'), $send_state, $delivery_info, $id));
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Item dequeued',
            );
        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            return (object) array(
                'status' => 0,
                'message' => DEBUG_MODE ? $e->getTraceAsString() : SERVER_ERROR_MESSAGE
            );
        }
    }
    // public static function dequeueSpecific($id)
    // {
    //     $connection = DatabaseController::connect();
    //     try {
    //         $query = $connection->prepare("DELETE FROM email_queue WHERE id = ?");
    //         $query->execute(array($id));
    //         DatabaseController::disconnect();
    //         return (object) array(
    //             'status' => 1,
    //             'message' => 'Item removed',
    //         );
    //     } catch (PDOException $e) {
    //         error_log($e->getMessage() .": ".$e->getTraceAsString());
    //         return (object) array(
    //             'status' => 0,
    //             'message' => DEBUG_MODE ? $e->getTraceAsString() : SERVER_ERROR_MESSAGE
    //         );
    //     }
    // }
    public static function getQueue()
    {
        $connection = DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM email_queue WHERE status = ? ORDER BY send_date ASC");
        $query->execute(['pending']);
        DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public static function front()
    {
        $connection = DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM email_queue WHERE status = ? ORDER BY send_date DESC LIMIT 1");
        $query->execute(['pending']);
        DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }
}