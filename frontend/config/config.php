<?php

ob_start();
date_default_timezone_set('Africa/Nairobi');
ini_set('error_log', '/../error.log');

$root = dirname(__DIR__, 2);

$htaccessFile = $root . '/.htaccess';

if (!file_exists($htaccessFile)) {
    echo "The .htaccess file is missing. Please ensure it is present in the directory.";
    exit;
}

if (file_exists($root.'/frontend/config/env/.config.json')) {
    $data = json_decode(file_get_contents($root.'/frontend/config/env/.config.json'));

    define('SITE_TITLE', $data->siteTitle);
    define('SITE_DESCRIPTION', $data->siteDescription);
    define('SITE_URL', $_SERVER['HTTPS'] ? "https://" . $_SERVER['HTTP_HOST'] : "http://". $_SERVER['HTTP_HOST']);
    define('SITE_KEYWORDS', $data->siteKeywords);
    define('API', $data->api);
    define('CMS', $data->cms);
    define('ASSETS', $data->assets);
    define('UPLOAD_SERVER', $data->uploadServer);

    require_once 'frontend/variable_declare.php';
}
else{
    echo "Configuration file is missing";
    exit;
}




