<?php

if (!isset($_SESSION)) {
    session_start();
}

$redirect = LOGIN_PAGE;

if (!isset($_SESSION['user']) && $page != 'login') {
    
    if (isset($_GET['token'])) {
        $decrypted_token = json_decode(decrypt_data($_GET['token']));

        $is_valid = false;

        if(property_exists($decrypted_token, 'timestamp')){
            $time_difference = time() - $decrypted_token->timestamp;
            if($time_difference < 3600){
                $is_valid = true;
            }
        }

        if ($is_valid) {
            $page_title = "ExcellePro | Password Reset";
            
            include_once 'views/auth/reset-password.php';
            exit;
        }
    }

    if (isset($_GET['code'])) {
        $code = $_GET['code'];

        if ($code) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, API);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

            $post_data = array(
                'object' => 'User',
                'action' => 'validate_access_code',
                'code' => $code
            );

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

            $curl_response = json_decode(curl_exec($ch));

            if($curl_response->status){
                $decoded_code = json_decode(decrypt_data($code));

                $_SESSION['user'] = $decoded_code->user;

            }

            $redirect = DIRADMIN;
        }
    }
    
    header('Location: '.$redirect);
} 
