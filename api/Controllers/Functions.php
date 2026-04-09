<?php
    include_once 'Email.php';
    class Functions {

        public static function sendEmail($data){
            ob_start();
            $email = new Email();
            $email->initializeParams($data);
            if ($data['recipient_email'] && !empty($data['recipient_email'])) {
                $email->send();   
            }
            $email_response = json_decode(ob_get_clean());
        }

        public static function smsSender($data){
            $email_params = array(
                'email' => $data[0],
                'first_name' => $data[1],
                'last_name' => $data[2],
                'subject' => $data[3],
                'message' => $data[4],
            );
            ob_start();
            $email = new Email();
            $email->initializeParams($email_params);
            if ($email_params['email'] && !empty($email_params['email'])) {
                $email->send();   
            }
            $email_response = json_decode(ob_get_clean());
        }

        public static function intlPhone ($phoneNumber, $code) {
            require __DIR__ . '../vendor/autoload.php';
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            try{
                $intlNumberProto = $phoneUtil->parse($phoneNumber, $code);
                return $phoneUtil->format($intlNumberProto, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
            }
            catch(\libphonenumber\NumberParseException $e){
                return NULL;
            }
        }
        
        public static function countryCode ($phoneNumber) {
            require __DIR__ . '../vendor/autoload.php';
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            try{
                $intlNumberProto = $phoneUtil->parse($phoneNumber, 'KE');
                return $phoneUtil->getRegionCodeForNumber($intlNumberProto);
            }
            catch(\libphonenumber\NumberParseException $e){
                return NULL;
            }
        }

        public static function validatePhoneNumber ($phoneNumber, $code) {
            require __DIR__ . '../vendor/autoload.php';
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            $intlNumberProto = $phoneUtil->parse($phoneNumber, $code);
            if (!is_null($intlNumberProto)) {
                return $phoneUtil->isValidNumber($intlNumberProto); 
            }  
            return false;
        }

        public static function nationalPhone ($phoneNumber) {
            require __DIR__ . '../vendor/autoload.php';
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            $code = self::countryCode($phoneNumber);
            try{
                $intlNumberProto = $phoneUtil->parse($phoneNumber, $code);
                return $phoneUtil->format($intlNumberProto, \libphonenumber\PhoneNumberFormat::NATIONAL);
            }
            catch(\libphonenumber\NumberParseException $e){
                return NULL;
            }
        }

        public static function slug ($string) {
            $slug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $string));
            if (empty($slug)) {
                return '';
            }
            else {
                return $slug;
            }
        }

        public static function camelCase ($string) {
            $noStrip = array();
            $string = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $string);
            $string = trim($string);
            $string = ucwords($string);
            $string = str_replace(" ", "", $string);
            $string = lcfirst($string);
            return $string;
        }

        public static function removeHeadings ($string) {
            $string = preg_replace("/\<h1(.*)\>(.*)\<\/h1\>|\<h2(.*)\>(.*)\<\/h2\>|\<h3(.*)\>(.*)\<\/h3\>|\<h4(.*)\>(.*)\<\/h4\>|\<h5(.*)\>(.*)\<\/h5\>|\<h6(.*)\>(.*)\<\/h6\>/","", $string);
            return $string;
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

        public static function mobileSlide ($src, $dest, $width, $height, $quality) {
            if (self::getFileExtension($src) == 'jpg' || self::getFileExtension($src) == 'jpeg') {
                $thumb_img = imagecreatefromjpeg($src);
            }
            if (self::getFileExtension($src) == 'png') {
                $thumb_img = imagecreatefrompng($src);
            }
            
            list($w, $h) = getimagesize($src);

            if (($w/$width) > ($h/$height)) {
                $y = 0;
                $x = $w - (($h * $width) / $height);
            } 
            else {
                $x = 0;
                $y = $h - (($w * $height) / $width);
            }

            $tmp = imagecreatetruecolor( $width, $height );
            imagecopyresampled( $tmp, $thumb_img, 0, 0, $x/2, $y/2, $width, $height, $w - $x, $h - $y);
            if(self::getFileExtension($src) == 'png') {
                imagepng($tmp, $dest);
            }
            if(self::getFileExtension($src) == 'jpg' || self::getFileExtension($src) == 'jpeg') {
                imagejpeg($tmp, $dest, $quality);
            }
            imagedestroy($tmp);
        }

        public static function getFileExtension ($path) {
            $path_parts = getimagesize($path);
            $extension_parts = explode('/', $path_parts['mime']);
            $extension = end($extension_parts);
            return $extension;
            /* $path_parts = pathinfo($path);
            return strtolower($path_parts['extension']); */
        }

        public static function limit_text ($text, $limit) {
            if(str_word_count($text, 0) > $limit) {
                $words = str_word_count($text, 2);
                $pos = array_keys($words);
                $text = substr($text, 0, $pos[$limit]) . '...';
            }
            return $text;
        }

        public static function squareThumb ($src, $dest, $width, $height, $quality) {
            if (self::getFileExtension($src) == 'jpg' || self::getFileExtension($src) == 'jpeg') {
                $thumb_img = imagecreatefromjpeg($src);
            }
            if (self::getFileExtension($src) == 'png') {
                $thumb_img = imagecreatefrompng($src);
            }
            
            list($w, $h) = getimagesize($src);
            if ($w > $h) {
                $new_height = $height;
                $new_width = floor($w * ($new_height / $h));
                $crop_x = ceil(($w - $h) / 2);
                $crop_y = 0;
            }
            else {
                $new_width = $width;
                $new_height = floor($h * ($new_width / $w));
                $crop_x = 0;
                $crop_y = ceil(($h - $w) / 2);
            }

            $tmp = imagecreatetruecolor($width, $height);
            imagecopyresampled($tmp, $thumb_img, 0, 0, $crop_x, $crop_y, $new_width, $new_height, $w, $h);
            if(self::getFileExtension($src) == 'png') {
                imagepng($tmp, $dest);
            }
            if(self::getFileExtension($src) == 'jpg' || self::getFileExtension($src) == 'jpeg') {
                imagejpeg($tmp, $dest, $quality);
            }
            imagedestroy($tmp);
        }

        public static function make_thumb ($src, $dest, $desired_width, $quality) {
            if (self::getFileExtension($src) == 'jpg' || self::getFileExtension($src) == 'jpeg') {
                $source_image = imagecreatefromjpeg($src);
            }
            if (self::getFileExtension($src) == 'png') {
                $source_image = imagecreatefrompng($src);
            }
            $width = imagesx($source_image);
            $height = imagesy($source_image);
            $desired_height = floor($height * ($desired_width / $width));
            $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
            if(self::getFileExtension($src) == 'png') {
                imagealphablending($virtual_image, false);
                imagesavealpha($virtual_image, true);
                $white = imagecolorallocatealpha($virtual_image, 255, 255, 255, 127);
                imagefill($virtual_image, 0, 0, $white);
            }
            imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
            if(self::getFileExtension($src) == 'png') {
                imagepng($virtual_image, $dest);
            }
            if(self::getFileExtension($src) == 'jpg' || self::getFileExtension($src) == 'jpeg') {
                imagejpeg($virtual_image, $dest, $quality);
            }
            imagedestroy($virtual_image);
        }

        public static function brand_image ($src, $dest, $desired_width, $imageSource, $font, $font_size, $angle) {
            $image_type = self::getFileExtension($src);
            if ($image_type == 'jpg' || $image_type == 'jpeg') {
                $source_image = imagecreatefromjpeg($src);
            }
            if ($image_type == 'png') {
                $source_image = imagecreatefrompng($src);
            }
            $width = imagesx($source_image);
            $height = imagesy($source_image);
            $marge_bottom = 10;
            $desired_height = floor($height * ($desired_width / $width));
            $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
            if ($image_type == 'png') {
                imagealphablending($virtual_image, false);
                imagesavealpha($virtual_image, true);
                $white = imagecolorallocatealpha($virtual_image, 255, 255, 255, 127);
                imagefill($virtual_image, 0, 0, $white);
            }
            imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
            $color = imagecolorallocate($virtual_image, 255, 255, 255);
            imagettftext($virtual_image, $font_size, $angle, 10, imagesy($virtual_image) - $marge_bottom, $color, $font, $imageSource );
            if ($image_type == 'jpg' || $image_type == 'jpeg') {
                imagejpeg($virtual_image, $dest);
            }
            if ($image_type == 'png') {
                imagepng($virtual_image, $dest);
            }
            imagedestroy($virtual_image);
        }

        public static function image_stamp ($src, $stamp, $dest) {
            $src = $src;
            $src_stamp = $stamp;
            $dest = $dest;
            if(self::getFileExtension($src) == 'jpg' || self::getFileExtension($src) == 'jpeg') {
                $image = imagecreatefromjpeg($src);
            }
            if(self::getFileExtension($src) == 'png') {
                $image = imagecreatefrompng($src);
            }
            if(self::getFileExtension($src_stamp) == 'jpg' || self::getFileExtension($src_stamp) == 'jpeg') {
                $stamp = imagecreatefromjpeg($src_stamp);
            }
            if(self::getFileExtension($src_stamp) == 'png') {
                $stamp = imagecreatefrompng($src_stamp);
            }
            $marge_right = 10;
            $marge_bottom = 10;
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);
            imagecopy($image, $stamp, imagesx($image) - $sx - $marge_right, imagesy($image) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
            if(self::getFileExtension($src) == 'jpg' || self::getFileExtension($src) == 'jpeg') {
                $newImage = imagejpeg($image, $dest);
            }
            if(self::getFileExtension($src) == 'png') {
                $newImage = imagepng($image, $dest);
            }
            imagedestroy($image);
        }

        public static function make_icon ($src, $dest, $desired_width) {
            if(self::getFileExtension($src) == 'jpg' || self::getFileExtension($src) == 'jpeg') {
                $source_image = imagecreatefromjpeg($src);
            }
            if(self::getFileExtension($src) == 'png') {
                $source_image = imagecreatefrompng($src);
            }
            $width = imagesx($source_image);
            $height = imagesy($source_image);
            if(empty($desired_width) || is_null($desired_width)) {
                $desired_width = $width;
            }
            $desired_height = floor($height * ($desired_width / $width));
            $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
            if(self::getFileExtension($src) == 'png'){
                imagealphablending($virtual_image, false);
                imagesavealpha($virtual_image, true);
                $white = imagecolorallocatealpha($virtual_image, 255, 255, 255, 127);
                imagefill($virtual_image, 0, 0, $white);
            }
            imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
            if(self::getFileExtension($src) == 'png') {
                imagepng($virtual_image, $dest);
            }
            if(self::getFileExtension($src) == 'jpg' || self::getFileExtension($src) == 'jpeg') {
                imagejpeg($virtual_image, $dest);
            }
            imagedestroy($virtual_image);
        }

        public static function makeFavicon ($source, $destination) {
            require __DIR__ . '../vendor/autoload.php';
            if (file_exists($source)) {
                $ico = new PHP_ICO($source, array(16, 16));
                $ico->save_ico($destination);  
                unlink($source); 
            }
        }

        public static function countPages ($totalItems, $items) {
            if(($totalItems % $items) > 0){
                $pages = floor($totalItems/$items) + 1;
            }
            else{
                $pages = ($totalItems/$items);
            }
            return $pages;
        }

        public static function removeEmails($string, $dir){
            $pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';
            $text = $string;
            $email = self::getEmails($text);
            $text = preg_replace($pattern, '<img src="'.$dir.'includes/text_image.php?string='.$email.'&location=contacts" alt="Email">', $text);		
            return $text;
        }
        
        public static function getEmails($string){
            $pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';
            $text = $string;
            $emails = array();
            preg_match_all($pattern, $text, $emails);
            if(isset($emails[0][0])){
                return $emails[0][0];
            }
            else{
                return null;
            }
        }

        public static function createPassword ($length = 10, $add_dashes = false, $available_sets = 'luds'){
            $sets = array();
            if(strpos($available_sets, 'l') !== false)
                $sets[] = 'abcdefghjkmnpqrstuvwxyz';
            if(strpos($available_sets, 'u') !== false)
                $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
            if(strpos($available_sets, 'd') !== false)
                $sets[] = '23456789';
            if(strpos($available_sets, 's') !== false)
                $sets[] = '!@#$%&*?{}[]()~';
            $all = '';
            $password = '';
            foreach($sets as $set){
                $password .= $set[array_rand(str_split($set))];
                $all .= $set;
            }
            $all = str_split($all);
            for($i = 0; $i < $length - count($sets); $i++)
                $password .= $all[array_rand($all)];
            $password = str_shuffle($password);
            if(!$add_dashes)
                return $password;
            $dash_len = floor(sqrt($length));
            $dash_str = '';
            while(strlen($password) > $dash_len){
                $dash_str .= substr($password, 0, $dash_len) . '-';
                $password = substr($password, $dash_len);
            }
            $dash_str .= $password;
            return $dash_str;
        }
        
        public static function randomCode () {
            $chars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ023456789';
            srand((double)microtime() * 1000000);
            $i = 0;
            $code = '';
            while($i < 10){
                $num = rand() % 33;
                $tmp = substr($chars, $num, 1);
                $code = $code.$tmp;
                $i++;
            }
            return $code;
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

        public static function firstWord ($string) {
            $arr = explode(' ',trim($string));
            return $arr[0];
        }

        public static function removeHTTP ($url) {
            $disallowed = array('http://', 'https://');
            foreach ($disallowed as $value) {
                if (strpos($url, $value) === 0) {
                    return str_replace($value, '', $url);
                }
            }
            return rtrim($url, '/');
        }

        public static function randomColor () {
            return '#'.self::randomColorPart().self::randomColorPart().self::randomColorPart();
        }

        public static function randomColorPart () {
            return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
        }

        public static function generateProfilePicture ($name, $path, $size) {
            require __DIR__ . '../vendor/autoload.php';
            $avatar = new LasseRafn\InitialAvatarGenerator\InitialAvatar();
            $image = $avatar->name($name); 
            $image->size($size);
            $image->background(self::randomColor());
            $image->color('#ffffff');
            $image->rounded()->smooth();
            $image->font(dirname(__DIR__).'/assets/fonts/Poppins/Poppins-Regular.ttf');
            $image->fontSize(0.4);
            $image->generate()->save(ROOT.'/'.$path, 100, 'png');
        }

        public static function maskPhoneNumber($number){
            $mask_number =  str_repeat("*", strlen($number)-4) . substr($number, -3);
            return $mask_number;
        }

        public static function stringToSecret(string $string = null) {
            if (!$string) {
                return null;
            }
            $length = strlen($string);
            $visibleCount = (int) round($length / 4);
            $hiddenCount = $length - ($visibleCount * 2);
            return substr($string, 0, $visibleCount) . str_repeat('*', $hiddenCount) . substr($string, ($visibleCount * -1), $visibleCount);
        }

        public static function MPESAPhoneMask ($number) {
            $number  = ltrim(str_replace(' ', '', $number), '+');
            $result = $number;
            $result = preg_replace('/^.{9}/', "$0 ", $number);
            $result = preg_replace('/^.{4}/', "$0 ", $result);
            $result = substr_replace($result, "*****", 5, 5);
            return $result;
        }

        public static function encryptData ($string) {
            $cipher = 'AES-128-ECB';
            $secret = SECRET_KEY;
            $iv_length = openssl_cipher_iv_length($cipher);
            $iv = substr($string, 0, $iv_length);
            return base64_encode(openssl_encrypt($string, $cipher, $secret, 0, $iv));
        }

        public static function decryptData ($string) {
            $cipher = 'AES-128-ECB';
            $secret = SECRET_KEY;
            $iv_length = openssl_cipher_iv_length($cipher);
            $iv = substr($string, 0, $iv_length);
            return openssl_decrypt(base64_decode($string), $cipher, $secret, 0, $iv);
        }

        public static function generateSMSBatchNo($string){
            $batch_no = "SMS".date('m').date('y')."-".str_pad($string, 4, '0', STR_PAD_LEFT);
            return $batch_no;
        }

        public static function generateInitials ($name) {
            $words = explode(' ', $name);
            if (count($words) >= 2) {
                return mb_strtoupper(
                    mb_substr($words[0], 0, 1, 'UTF-8') . 
                    mb_substr($words[1], 0, 1, 'UTF-8'), 
                'UTF-8');
            }
            return self::generateInitialsFromSingleWord($name);
        }

        public static function generateInitialsFromSingleWord ($name) {
            preg_match_all('#([A-Z]+)#', $name, $capitals);
            if (count($capitals[1]) >= 2) {
                return mb_substr(implode('', $capitals[1]), 0, 2, 'UTF-8');
            }
            return mb_strtoupper(mb_substr($name, 0, 2, 'UTF-8'), 'UTF-8');
        }

        public static function isBase64Encoded($string) {
            // Check if there are any characters not in the Base64 alphabet
            // Also checks for the correct padding by using `% 4`
            if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string) && (strlen($string) % 4 == 0)) {
                return true;
            }
            return false;
        }
    }