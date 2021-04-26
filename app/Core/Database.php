<?php

namespace app\Core;

class Database
{
    public string $db_host;
    public string $db_port;
    public string $db_name;
    public string $db_username;
    public string $db_password;
    public \PDO $connection;

    public function __construct()
    {
        $this->db_host = $_ENV['DB_HOST'];
        $this->db_port = $_ENV['DB_PORT'];
        $this->db_name = $_ENV['DB_DATABASE'];
        $this->db_username = $_ENV['DB_USERNAME'];
        $this->db_password = $_ENV['DB_PASSWORD'];

        try {
            $this->connection = new \PDO(
                "mysql:host=$this->db_host;port=$this->db_port;charset=utf8mb4;dbname=$this->db_name",
                $this->db_username,
                $this->db_password
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection(): \PDO
    {
        return $this->connection;
    }
}