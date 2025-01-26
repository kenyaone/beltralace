<?php

class Gmail{

    public static function getMessages($refresh_token)
    {
        $client = GoogleCloud::setupClientConfigured();
        $access_token = $client->refreshToken($refresh_token);
        $client->setAccessToken($access_token);
        $service = new Google\Service\Gmail($client);

        return $service->users_messages->get('me', '18df9de2acf35c45');
    }
}