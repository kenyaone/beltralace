<?php

$host = '';
$dbname = '';
$user = '';
$password = '';

$settings = json_decode(file_get_contents('config/env/.database.json'));
if (isset($settings->host) && !empty($settings->host)) {
    $host = $settings->host;
}
if (isset($settings->database) && !empty($settings->database)) {
    $dbname = $settings->database;
}
if (isset($settings->user) && !empty($settings->user)) {
    $user = $settings->user;
}
if (isset($settings->password) && !empty($settings->password)) {
    $password = $settings->password;
}

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => $host,
            'name' => $dbname,
            'user' => $user,
            'pass' => $password,
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => $host,
            'name' => $dbname,
            'user' => $user,
            'pass' => $password,
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => $host,
            'name' => $dbname,
            'user' => $user,
            'pass' => $password,
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
