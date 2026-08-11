<?php

class Database
{
    private string $host;
    private string $db_name;
    private string $username;
    private string $password;

    public ?PDO $conn = null;

    public function __construct()
    {
        $env = parse_ini_file(__DIR__ . '/../../.env');

        if ($env === false) {
            throw new RuntimeException('Die .env-Datei konnte nicht geladen werden.');
        }

        $this->host = $env['DB_HOST'];
        $this->db_name = $env['DB_NAME'];
        $this->username = $env['DB_USER'];
        $this->password = $env['DB_PASSWORD'];
    }

    public function getConnection(): ?PDO
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $this->conn;

        } catch (PDOException $exception) {
            echo "Verbindungsfehler: " . $exception->getMessage();
            return null;
        }
    }
}