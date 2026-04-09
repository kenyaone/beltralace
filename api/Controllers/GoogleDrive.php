<?php

class GoogleDrive
{
    public function test($access_token)
    {
        $client = GoogleCloud::setupClientConfigured();
        $client->setAccessToken($access_token);
        $drive = new Google\Service\Drive($client);
        // $files = $drive->files->listFiles(array())->getItems();
        // $files = $drive->files->listFiles(ar)
        // return json_encode($files);
    }

    public static function uploadFile($file_path, $refresh_token)
    {
        $client = GoogleCloud::setupClientConfigured();
        $access_token = $client->refreshToken($refresh_token);
        $client->setAccessToken($access_token);
        $service = new Google\Service\Drive($client);
        $file = new Google\Service\Drive\DriveFile(); 
        $file_name = pathinfo($file_path)['basename'];
        $file->setName('backups/'.$file_name);
        $result = $service->files->create(
            $file,
            [
                'data' => file_get_contents($file_path),
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'media'
            ]
        );
    }
}
