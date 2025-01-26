<?php
class EmailInfobip{
    public static function send($data){
        try {
            $url = INFOBIP_URL;
    
            foreach($data['recipients'] as $recipient){
                $recipients[] = json_encode(array(
                    "to" => $recipient['to'],
                    "placeholders" => array(
                        "name" => ''
                    )
                ));
            }
            
            $post_data = array(
                "from" => COMPANY_NAME." <".DEFAULT_SEND_EMAIL.">",
                "to" => $recipients,
                "replyTo" => array_key_exists("reply_to_email", $data) && $data["reply_to_email"] ? $data["reply_to_email"] : DEFAULT_REPLY_EMAIL,
                "subject" => $data['subject'],
                // "text" => "Dear {{name}}, this is mail body text with placeholders in body",
                "html" => html_entity_decode($data['body']),
                "notifyContentType" => "application/json",
                "notifyUrl" => "",
                "trackOpens" => "",
                "trackingUrl" => ""
            );
            
            $boundary = uniqid(); // Generate a unique boundary
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, self::build_multipart_data($post_data, $boundary));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: multipart/form-data; boundary=$boundary",
                "Accept: application/json",
                "Authorization: App ".INFOBIP_APIKEY
            ));
            
            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
            }
            
            curl_close($ch);
            
            return $response;
        
        } 
        catch (Exception $e) {

        }
    }

    private static function build_multipart_data($data, $boundary) {
        $multipart_data = '';
    
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $element) {
                    $multipart_data .= "--$boundary\r\n";
                    $multipart_data .= "Content-Disposition: form-data; name=\"$key\"\r\n\r\n";
                    $multipart_data .= "$element\r\n";
                }
            } else {
                $multipart_data .= "--$boundary\r\n";
                $multipart_data .= "Content-Disposition: form-data; name=\"$key\"\r\n\r\n";
                $multipart_data .= "$value\r\n";
            }
        }
    
        $multipart_data .= "--$boundary--";
    
        return $multipart_data;
    }
    
    
}