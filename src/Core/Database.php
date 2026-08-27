<?php

namespace LawFirmManagement\Core;

use PDO;
use PDOException;

class Database
{
    private PDO $connection;

    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};"
             . "port={$config['port']};"
             . "dbname={$config['database']};"
             . "charset=utf8mb4";

        try {
            $this->connection = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            throw new \RuntimeException(
                'Database connection failed.',
                0,
                $e
            );
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}