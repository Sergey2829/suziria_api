<?php

namespace Suziria\ProductApi\Config;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;

class Database
{
    private static ?self $instance = null;
    private Connection $connection;

    private function __construct()
    {
        $params = [
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'driver' => 'pdo_pgsql',
        ];

        $this->connection = DriverManager::getConnection($params);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }


    private function __clone() {}


    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
} 