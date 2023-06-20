<?php
  class Database {
    // DB Params
    private $host = 'localhost:3306';
    private $db_name = 'carlon_social_media';
    private $username = 'carlon_connect';
    private $password = 's111l3nc3R';
    private $conn;

    //DB Connct
    public function connect() {
      $this->conn = null;

      try {
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }