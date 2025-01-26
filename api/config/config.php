<?php

ob_start();
date_default_timezone_set('Africa/Nairobi');
ini_set('error_log', dirname(__DIR__) . '/error.log');

use App\Controllers\DatabaseController;
use App\Controllers\SettingsController;

$connection = DatabaseController::connect();

if (is_numeric($connection)) {
    echo "Failed to connect to database";
    exit;
} 
else {
    include_once realpath(__DIR__ .'/../controllers/Functions.php');

    $config = SettingsController::get_configs();

    if (is_object($config)) {
        define('SECRET_KEY', $config->secretKey);
        define('DIRADMIN', $config->admin);
        define('WEBSITE', $config->website);

    } else {
        echo "Configuration file is missing";
        exit;
    }
}
