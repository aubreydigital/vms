<?php

class Database {
    private $host = 'localhost:8889';
    private $db_name = 'social_media';
    private $username = 'root';
    private $password = 'root';
    private $conn;

    public function connect() {
        $this->conn = null;

        try  {
            // $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
