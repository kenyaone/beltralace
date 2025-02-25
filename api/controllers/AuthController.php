<?php

namespace App\Controllers;

use \PDO;
use \PDOException;
use App\Models\User;
use App\Helpers\HelperFunctions;
use Firebase\JWT\JWT;

class AuthController{
    private $userController;

    public function __construct()
    {
        // $this->userController = $userController;
    }
    public function login (User $user) {
        if (is_null($user->email) || is_null($user->password)) {
            return (object) array(
                'status' => 0,
                'message' => 'Empty email and/or password'
            );
        }
        else {
            $userController = new UserController();
            $user_details = $userController->getByEmail($user->email);
            if ($user_details->id) {
                if ($user_details->active) {
                    if (password_verify($user->password, $user_details->password)) {
                        return (object) array(
                            'status' => 1,
                            'message' => 'Login successful. Redirecting...',
                            'code' => self::generateAccessCode($user_details->id)
                        );
                    }
                    http_response_code(422);
                    return (object) array(
                        'status' => 0,
                        'message' => 'Invalid password'
                    );
                }
                else {
                    http_response_code(422);
                    return (object) array(
                        'status' => 0,
                        'message' => 'Inactive user account. Contact your administrator for assistance'
                    );
                }
            }
            else {
                http_response_code(422);
                return (object) array(
                    'status' => 0,
                    'message' => 'Wrong email'
                );
            }    
        }  
    }

    public function register (User $user) {
        if (is_null($user->email) || is_null($user->password)) {
            return (object) array(
                'status' => 0,
                'message' => 'Empty email and/or password'
            );
        }
        else {
            $userController = new UserController();
            $user_details = $userController->getByEmail($user->email);
            if ($user_details->id) {
                if ($user_details->active) {
                    if (password_verify($user->password, $user_details->password)) {
                        return (object) array(
                            'status' => 1,
                            'message' => 'Login successful. Redirecting...',
                            'code' => self::generateAccessCode($user_details->id)
                        );
                    }
                    http_response_code(422);
                    return (object) array(
                        'status' => 0,
                        'message' => 'Invalid password'
                    );
                }
                else {
                    http_response_code(422);
                    return (object) array(
                        'status' => 0,
                        'message' => 'Inactive user account. Contact your administrator for assistance'
                    );
                }
            }
            else {
                http_response_code(422);
                return (object) array(
                    'status' => 0,
                    'message' => 'Wrong email'
                );
            }    
        }  
    }
    public static function generateAccessCode($user_id)
    {
        $raw_code = array(
            'user' => UserController::getById($user_id),
            'access_token' => self::generateToken($user_id)
        );

        $access_code = HelperFunctions::encryptData(json_encode($raw_code));
        self::storeAccessCode($access_code, $user_id);
        return $access_code;
    }
    public static function generateToken($user_id)
    {
        $issue_time = time();
        $not_before = $issue_time;
        $payload = array(
            "iss" => $_SERVER['SERVER_NAME'], // Issuer
            "aud" => self::getIpAddress(), // Audience
            "iat" => $issue_time, // Time JWT was issued
            "nbf" => $not_before, // Time JWT should start being functional
            // "exp" => $expiry_time, // Time JWT expires
            "user_id" => $user_id
        );

        $jwt = JWT::encode($payload, SECRET_KEY, 'HS256');
        // echo json_encode(array(
        //     'jwt' => $jwt,
        //     'payload' => $payload,
        //     'leeway' => JWT::$leeway
        // ), JSON_PRETTY_PRINT);

        return $jwt;
    }
    private static function storeAccessCode($access_code, $user_id)
    {
        global $connection;

        $query = $connection->prepare("INSERT INTO user_access_codes (user_id, access_code) VALUES (?, ?) ON DUPLICATE KEY UPDATE access_code = VALUES(access_code)");
        $query->execute(array($user_id, $access_code));
    }
    private static function retrieveAccessCode($access_code)
    {
        global $connection;

        $query = $connection->prepare("SELECT * from user_access_codes where user_access_codes.access_code = ?");
        $query->execute(array($access_code));
        return $query->fetch(PDO::FETCH_OBJ);
    }
    private static function deleteAccessCode($access_code)
    {
        global $connection;

        $query = $connection->prepare("DELETE from user_access_codes where user_access_codes.access_code = ?");
        $query->execute(array($access_code));
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public static function getIpAddress()
    {
        $ipAddress = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // to get shared ISP IP address
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check for IPs passing through proxy servers
            // check if multiple IP addresses are set and take the first one
            $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipAddressList as $ip) {
                if (!empty($ip)) {
                    // if you prefer, you can check for valid IP address here
                    $ipAddress = $ip;
                    break;
                }
            }
        } else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        return $ipAddress;
    }
}