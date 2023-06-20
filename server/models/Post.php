<?php
    class Post {
        private $conn;
        private $table = 'post';

        //User properies
        public $post_id;
        public $user_name;
        public $user_id;
        public $title;
        public $post;
        public $created_at;
        public $likes;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
                $query = 
                'SELECT p.post_id,
                        p.user_name,
                        p.user_id,
                        p.title,
                        p.post,
                        p.created_at,
                        p.likes
                FROM
                    ' . $this->table . ' p
                ORDER BY
                    p.created_at DESC';
                
            //prepare statement
            $stmt = $this->conn->prepare($query);
            //execute query
            $stmt->execute();

            return $stmt;
        }

        public function read_single() {

                $query = 
                'SELECT 
                    p.post_id,
                    p.user_name,
                    p.user_id,
                    p.title,
                    p.post,
                    p.likes,
                    p.created_at
                FROM '
                    . $this->table . ' p
                WHERE
                    p.post_id = ?
                LIMIT 0,1';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind id
            $stmt->bindParam(1, $this->post_id);

            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->post_id = $row['post_id'];
            $this->user_name = $row['user_name'];
            $this->user_id = $row['user_id'];
            $this->title = $row['title'];
            $this->post = $row['post'];
            $this->likes = $row['likes'];
            $this->created_at = $row['created_at'];            
        }

        public function create() {
            // $headers = apache_request_headers();
            // if(isset($headers['Authorization'])):
            // $token = str_replace('Bearer ', '', $headers['Authorization']);
            // try {
            //     $token = JWT::decode($token, $this->key, array('HS512'));
                $query = 'INSERT INTO ' . $this->table . '
            SET
                user_name = :user_name,
                user_id = :user_id,
                post = :post,
                title = :title,
                likes = :likes';
        
            //prepare
            $stmt = $this->conn->prepare($query);

            //sanitize
            $this->user_name = htmlspecialchars(strip_tags($this->user_name));
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->post = htmlspecialchars(strip_tags($this->post));
            $this->likes = htmlspecialchars(strip_tags($this->likes));

            //bind data
            $stmt->bindParam(':user_name', $this->user_name);
            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':post', $this->post);
            $stmt->bindParam(':likes', $this->likes);

            //execute
            if($stmt->execute()) {
                return true;
            } 

            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        public function update() {
            // $headers = apache_request_headers();
            // if(isset($headers['Authorization'])):
            // $token = str_replace('Bearer ', '', $headers['Authorization']);
            // try {
            //     $token = JWT::decode($token, $this->key, array('HS512'));
                $query = 'UPDATE ' . $this->table . '
            SET
                title = :title,
                post = :post,
                likes = :likes

            WHERE
                post_id = :post_id';
            
            $stmt = $this->conn->prepare($query);

            $this->post_id = htmlspecialchars(strip_tags($this->post_id));
            $this->post = htmlspecialchars(strip_tags($this->post));
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->likes = htmlspecialchars(strip_tags($this->likes));
            
            $stmt->bindParam(':post_id', $this->post_id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':post', $this->post);
            $stmt->bindParam(':likes', $this->likes);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n", $stmt->error);

            return false;
        //     } catch(\Exception $e) {
        //         return false;
        //     }
        // else:
        //     return false;
        // endif;
            
        }

        public function delete() {
            // $headers = apache_request_headers();
            // if(isset($headers['Authorization'])):
            // $token = str_replace('Bearer ', '', $headers['Authorization']);
            // try {
            //     $token = JWT::decode($token, $this->key, array('HS512'));
                $query = 'DELETE FROM ' . $this->table . ' WHERE post_id = :post_id';

            $stmt = $this->conn->prepare($query);

            $this->post_id = htmlspecialchars(strip_tags($this->post_id));

            $stmt->bindParam(':post_id', $this->post_id);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n", $stmt->error);

            return false;
        //     } catch(\Exception $e) {
        //         return false;
        //     }
        // else:
        //     return false;
        // endif;
            
        }

        public function update_likes() {
            // $headers = apache_request_headers();
            // if(isset($headers['Authorization'])):
            // $token = str_replace('Bearer ', '', $headers['Authorization']);
            // try {
            //     $token = JWT::decode($token, $this->key, array('HS512'));
                $query = 'UPDATE ' . $this->table . '
            SET
                likes = :likes

            WHERE
                post_id = :post_id';
            
            $stmt = $this->conn->prepare($query);

            $this->likes = htmlspecialchars(strip_tags($this->likes));

            $stmt->bindParam(':likes', $this->likes);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n", $stmt->error);

            return false;

        }
    }

    