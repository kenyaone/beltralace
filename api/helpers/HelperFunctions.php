<?php

namespace App\Helpers;

class ValidationException extends \Exception {}
class HelperFunctions
{
    public static function capitalizeFirstChars($string)
    {
        $words = explode(" ", $string);
        $formatted_string = "";
        foreach ($words as $word) {
            $formatted_string .= ucfirst($word) . " ";
        }
        return trim($formatted_string);
    }

    public static function hexToRGB($hex) {
        // Ensure hex is a string, trimming any surrounding whitespace
        $hex = trim($hex);
    
        // Check if hex color starts with '#', remove it if present
        if (substr($hex, 0, 1) == '#') {
            $hex = substr($hex, 1);
        }
    
        // If it's a 3-character hex code, convert it to 6 characters
        if (strlen($hex) == 3) {
            $hex = substr($hex, 0, 1) . substr($hex, 0, 1) .
                   substr($hex, 1, 1) . substr($hex, 1, 1) .
                   substr($hex, 2, 1) . substr($hex, 2, 1);
        }
    
        // Get the red, green, and blue components
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    
        // Return as array
        $rgbColor = array($r, $g, $b);

        return "(" . implode(", ", $rgbColor) . ")";
    }

    public static function encryptData($string){
        $cipher = 'AES-128-ECB';
        $secret = SECRET_KEY;
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = substr($string, 0, $iv_length);
        return base64_encode(openssl_encrypt($string, $cipher, $secret, 0, $iv));
    }
    
    public static function decryptData($string){
        $cipher = 'AES-128-ECB';
        $secret = SECRET_KEY;
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = substr($string, 0, $iv_length);
        return openssl_decrypt(base64_decode($string), $cipher, $secret, 0, $iv);
    }
    
    public static function generatePasswordResetToken($user_id){
        $data = array(
            'token' => self::encryptData($user_id),
            'timestamp' => time()
        );

        return self::encryptData(json_encode($data));
    }

    public static function validatePasswordResetToken($token){
        $is_valid = false;

        $decrypted_token = json_decode(self::decryptData($token));
        if(is_array($decrypted_token)){
            $time_difference = time() - $decrypted_token['timestamp'];
            if($time_difference < 3600){
                $is_valid = true;
            }
        }

        return $is_valid;
    }

    public static function generatePassword()
    {
        $chars = "0123456789";
        $user_password = substr(str_shuffle($chars), 0, 4);
        return $user_password;
    }

    public static function validateData($data, $fields){
        $missing_fields = [];
    
        foreach($fields as $field){
            if(!array_key_exists($field, $data) || !isset($data[$field]) || empty($data[$field])){
                $missing_fields[] = $field;
            }
        }
    
        if(!empty($missing_fields)){
            throw new ValidationException('Missing required fields: ' . implode(', ', $missing_fields));
        }
    }

    public static function slugisize($string){
        return str_replace(" ", "-", strtolower($string));
    }

    public static function getFileExtension ($path) {
        $path_parts = getimagesize($path);
        $extension_parts = explode('/', $path_parts['mime']);
        $extension = end($extension_parts);
        return $extension;
    }
    
    public static function resize_image ($src, $dest, $desired_width) {
        $image_type = self::getFileExtension($src);
        if ($image_type == 'jpg' || $image_type == 'jpeg') {
            $source_image = @imagecreatefromjpeg($src);
        }
        if ($image_type == 'png') {
            $source_image = imagecreatefrompng($src);
        }
        if ($image_type == 'webp') {
            $source_image = imagecreatefromwebp($src);
        }
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $desired_height = floor($height * ($desired_width / $width));
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        if($image_type == 'png') {
            imagealphablending($virtual_image, false);
            imagesavealpha($virtual_image, true);
            $white = imagecolorallocatealpha($virtual_image, 255, 255, 255, 127);
            imagefill($virtual_image, 0, 0, $white);
        }
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        if ($image_type == 'png') {
            imagepng($virtual_image, $dest, 9);
        }
        if ($image_type == 'jpg' || $image_type == 'jpeg') {
            imagejpeg($virtual_image, $dest, 100);
        }
        if ($image_type == 'webp') {
            imagewebp($virtual_image, $dest, 100);
        }
        imagedestroy($virtual_image);
    }

    public static function webp_image ($src, $dest, $d_width, $d_height, $quality) {
        $file_ext = self::getFileExtension($src);
        switch ($file_ext) {
            case 'jpg':
                $source_image = imagecreatefromjpeg($src);
                break;

            case 'jpeg':
                $source_image = imagecreatefromjpeg($src);
                break;

            case 'png':
                $source_image = imagecreatefrompng($src);
                break;

            case 'webp':
                $source_image = imagecreatefromwebp($src);
                break;
            
            default:
                
                break;
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $virtual_image = imagecreatetruecolor($d_width, $d_height);

        if ($file_ext == 'png') {
            imagealphablending($virtual_image, false);
            imagesavealpha($virtual_image, true);
            $white = imagecolorallocatealpha($virtual_image, 255, 255, 255, 127);
            imagefill($virtual_image, 0, 0, $white);   
        }

        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $d_width, $d_height, $width, $height);

        imagewebp($virtual_image, $dest, $quality);
        imagedestroy($virtual_image);
    }

    public static function readFileContents ($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            curl_close($ch);
            return curl_error($ch);
        }
        curl_close($ch);
        return $data;
    }

    public static function isBase64Encoded($string) {
        // Check if there are any characters not in the Base64 alphabet
        // Also checks for the correct padding by using `% 4`
        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string) && (strlen($string) % 4 == 0)) {
            return true;
        }
        return false;
    }

    public static function limit_text ($text, $limit) {
        if(str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
    public static function deleteFile ($path) {
        if (file_exists($path)) {
            unlink($path);
        }
        return true;
    }
}
