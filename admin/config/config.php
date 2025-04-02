<?php
date_default_timezone_set('Africa/Nairobi');
ini_set('error_log', dirname(__DIR__) . '/error.log');

$root = dirname(dirname(__FILE__));

if (file_exists($root.'/config/env/.config.json')) {

    $data = json_decode(file_get_contents($root.'/config/env/.config.json'));

    define('SITETITLE', $data->site_title);
    define('SITEURL', $_SERVER['HTTP_HOST']);
    define('WEBSITE', $data->website);
    define('DIR', $_SERVER['DOCUMENT_ROOT']);
    define('DIRADMIN', '/');
    define('VIEWS', DIR.'/views');
    define('ASSETS_PATH', '/assets');
    define('UPLOADS_PATH', '/uploads');
    define('API', $data->api);
    define('LOGIN_PAGE', $data->login_page);
    define('CMS', $data->cms);
    define('SECRET_KEY', $data->secret_key);

    require_once 'functions.php';

}
else{
    echo "Configuration file is missing";
    exit;
}