<?php

namespace App\Controllers;

use \PDO;
use \PDOException;

class SettingsController{

    public $id = null;
    public $name = null;
    public $phone = null;
    public $email = null;
    public $address = null;
    public $tagline = null;
    public $facebook = null;
    public $instagram = null;
    public $linkedin = null;
    public $youtube = null;
    public $twitter = null;
    public $tiktok = null;
    public $author = null;

    public $object = null;
    public $action = null;

    

    public function initializeParams($data = array())
    {
        if (isset($data['id']) && !empty($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['name']) && !empty($data['name'])) {
            $this->name = $data['name'];
        }
        if (isset($data['phone']) && !empty($data['phone'])) {
            $this->phone = $data['phone'];
        }
        if (isset($data['email']) && !empty($data['email'])) {
            $this->email = $data['email'];
        }
        if (isset($data['address']) && !empty($data['address'])) {
            $this->address = $data['address'];
        }
        if (isset($data['tagline']) && !empty($data['tagline'])) {
            $this->tagline = $data['tagline'];
        }
        if (isset($data['facebook']) && !empty($data['facebook'])) {
            $this->facebook = $data['facebook'];
        }
        if (isset($data['instagram']) && !empty($data['instagram'])) {
            $this->instagram = $data['instagram'];
        }
        if (isset($data['linkedin']) && !empty($data['linkedin'])) {
            $this->linkedin = $data['linkedin'];
        }
        if (isset($data['youtube']) && !empty($data['youtube'])) {
            $this->youtube = $data['youtube'];
        }
        if (isset($data['twitter']) && !empty($data['twitter'])) {
            $this->twitter = $data['twitter'];
        }
        if (isset($data['tiktok']) && !empty($data['tiktok'])) {
            $this->tiktok = $data['tiktok'];
        }
        if (isset($data['author']) && !empty($data['author'])) {
            $this->author = $data['author'];
        }


        if (isset($data['object']) && !empty($data['object'])) {
            $this->object = $data['object'];
        }
        if (isset($data['action']) && !empty($data['action'])) {
            $this->action = $data['action'];
        }
    }

    public function update()
    {
        $connection =  DatabaseController::connect();
        try {
            $original_settings = self::get_settings();
            $query = $connection->prepare("UPDATE settings SET name = ?, phone = ?, email = ?, address = ?, tagline = ?, facebook = ?, instagram = ?, linkedin = ?, youtube = ?, twitter = ?, tiktok = ?, author = ? WHERE id = ?");
            $query->execute(array($this->name, $this->phone, $this->email, $this->address, $this->tagline, $this->facebook, $this->instagram, $this->linkedin, $this->youtube, $this->twitter, $this->tiktok, $this->author, $this->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'Settings updated successfully'
            ));

            if ($this->id) {
                $data = array(
                    "user_id" => $this->author,
                    "subject" => "Settings Updated",
                    "description" => "Updated settings: '" . json_encode($original_settings),
                    "object" => $this->object,
                    "item_id" => $this->id,
                );
                $transaction_log = new UserTransactionLog();
                $transaction_log->initializeParams($data);
                $transaction_log->create();
            }
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
        }
    }
    public static function get_settings () {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM settings");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function get_configs () {
        $root = dirname(dirname(__FILE__));
        if (file_exists($root.'/config/env/.config.json')) {
            $data = file_get_contents($root.'/config/env/.config.json');
        }
        else {
            $data = null;
        }
        $data = json_decode($data);

        return $data;
    }
}