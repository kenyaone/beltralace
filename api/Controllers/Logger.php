<?php

class Logger{
    public static function logApiResponse ($content, $section){
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO api_logs(content, section) VALUES(?, ?) ");
            $result = $query->execute(array($content, $section));
            $id = $connection->lastInsertId();
             DatabaseController::disconnect();
            if ($id) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }
}