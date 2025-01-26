<?php

namespace App\Models;

class User
{
    public static $user_id;
    public $id;
    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $username;
    public $biography;
    public $password;
    public $avatar;
    public $active;
    public $sa;

    public function __construct($data = array())
    {
        $this->id = $data['id'] ?? null;
        $this->first_name = $data['first_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->biography = $data['biography'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->avatar = $data['avatar'] ?? null;
        $this->active = $data['active'] ?? null;
        $this->sa = $data['sa'] ?? null;
    }
}
