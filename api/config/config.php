<?php

ob_start();
date_default_timezone_set('Africa/Nairobi');
ini_set('error_log', dirname(__DIR__) . '/error.log');

include_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Controllers\DatabaseController;
use App\Controllers\SettingsController;
use App\Core\EnvLoader;

$connection = DatabaseController::connect();

if (is_numeric($connection)) {
    echo "Failed to connect to database";
    exit;
} 
else {
    include_once realpath(__DIR__ .'/../Controllers/Functions.php');

    $config = SettingsController::get_configs();

    if (is_object($config)) {
        define('SITETITLE', $config->siteTitle);
        define('SECRET_KEY', $config->secretKey);
        define('DIR', $config->webAddress);
        define('DIRADMIN', $config->admin);
        define('WEBSITE', $config->website);
        define('BRANDCOLOR_PRIMARY', $config->brandColorPrimary);
        define('BRANDCOLOR_SECONDARY', $config->brandColorSecondary);

        define('DEBUG_MODE', TRUE);
        define('SERVER_ERROR_MESSAGE', 'Server Error Occurred');

        // Email configurations
        define('MAIL_TEMPLATES', 'views/mail_templates/');
        define('EMAIL_DEBUG_MODE', FALSE);
		define('EMAIL_HOST', $config->emailHost);
        define('EMAIL', $config->email);
        define('EMAIL_PASSWORD', $config->emailPassword);

        define('ADMIN_EMAIL', "beltralace@gmail.com");

        
        EnvLoader::load();
    } else {
        echo "Configuration file is missing";
        exit;
    }
}
