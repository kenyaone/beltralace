<?php

namespace App\Core;

use Dotenv\Dotenv;

class EnvLoader
{
    private static bool $loaded = false;

    public static function load(?string $rootPath = null): void
    {
        if (self::$loaded) {
            return;
        }

        $rootPath = $rootPath ? $rootPath : dirname(__DIR__);
        if ($rootPath && file_exists($rootPath . '/.env')) {
            Dotenv::createImmutable($rootPath)->safeLoad();
            self::$loaded = true;
            return;
        }
    }
}