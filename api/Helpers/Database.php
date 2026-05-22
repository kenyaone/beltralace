<?php

namespace App\Helpers;

use PDO;
use PDOException;
use App\Core\Exceptions\DatabaseException;
class Database
{
    private static ?self $instance = null;
    private ?PDO $connection;

    private function __construct()
    {
        $required = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'];

        foreach ($required as $key) {
            if (!array_key_exists($key, $_ENV)) {
                throw new \Exception("Database configuration error: {$key} is missing from .env");
            }
        }

        try {
            $host    = $_ENV['DB_HOST'];
            $name    = $_ENV['DB_NAME'];
            $user    = $_ENV['DB_USER'];
            $pass    = $_ENV['DB_PASSWORD'];
            $port    = $_ENV['DB_PORT']    ?? '3306';
            $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

            $this->connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new DatabaseException("Database connection failed: " . $e->getMessage(), (int) $e->getCode());
        }
    }

    /**
     * Get the singleton instance of the Database class.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get the PDO connection.
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Close the database connection.
     */
    public function disconnect(): void
    {
        $this->connection = null;
        self::$instance   = null;
    }

    /**
     * Prevent cloning of the singleton instance.
     */
    private function __clone() {}

    /**
     * Prevent unserializing the singleton instance.
     */
    public function __wakeup() {}
}