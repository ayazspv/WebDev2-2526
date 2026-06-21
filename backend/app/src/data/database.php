<?php

namespace App\Data;

use PDO;
use PDOException;

class Database {
    private $host = "db";
    private $db_name = "CircuTrade";
    private $username = "dbmanager";
    private $password = "dbpassword";
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
