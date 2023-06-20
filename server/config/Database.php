<?php
//offline db connect
// class Database {
//     private $host = 'localhost:8889';
//     private $db_name = 'social_media';
//     private $username = 'root';
//     private $password = 'root';
//     private $conn;

//     public function connect() {
//         $this->conn = null;

//         try  {
//             // $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
//             $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
//             $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         } catch(PDOException $e) {
//             echo 'Connection Error: ' . $e->getMessage();
//         }

//         return $this->conn;
//     }
// } -->

//online db connect
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
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->conn->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }