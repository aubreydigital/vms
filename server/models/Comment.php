<?php
    class Comment {
        private $conn;
        private $table = 'comments';

        //User properies
        public $comment_id;
        public $user_name;
        public $post_id;
        public $comment;
        public $created_at;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
                $query = 
                'SELECT p.comment_id,
                        p.user_name,
                        p.post_id,
                        p.comment,
                        p.created_at
                FROM
                    ' . $this->table . ' p
                ORDER BY
                    p.created_at DESC';
                
            //prepare statement
            $stmt = $this->conn->prepare($query);
            //execute query
            $stmt->execute();

            return $stmt;
            // } catch(\Exception $e) {
            //     return false;
            // };
        // else:
        //     return false;
        // endif;
        }

        public function read_single() {

                $query = 
                'SELECT 
                    p.comment_id,
                    p.user_name,
                    p.post_id,
                    p.comment,
                    p.created_at
                FROM '
                    . $this->table . ' p
                WHERE
                    p.comment_id = ?
                LIMIT 0,1';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind id
            $stmt->bindParam(1, $this->user_id);

            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->comment_id = $row['comment_id'];
            $this->user_name = $row['user_name'];
            $this->post_id = $row['post_id'];
            $this->comment = $row['comment'];
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
                post_id = :post_id,
                comment = :comment';
        
            //prepare
            $stmt = $this->conn->prepare($query);

            //sanitize
            $this->user_name = htmlspecialchars(strip_tags($this->user_name));
            $this->post_id = htmlspecialchars(strip_tags($this->post_id));
            $this->comment = htmlspecialchars(strip_tags($this->comment));

            //bind data
            $stmt->bindParam(':user_name', $this->user_name);
            $stmt->bindParam(':post_id', $this->post_id);
            $stmt->bindParam(':comment', $this->comment);

            //execute
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

        public function update() {
            // $headers = apache_request_headers();
            // if(isset($headers['Authorization'])):
            // $token = str_replace('Bearer ', '', $headers['Authorization']);
            // try {
            //     $token = JWT::decode($token, $this->key, array('HS512'));
                $query = 'UPDATE ' . $this->table . '
            SET
                comment = :comment,

            WHERE
                comment_id = :comment_id';
            
            $stmt = $this->conn->prepare($query);

            $this->comment = htmlspecialchars(strip_tags($this->comment));
            
            $stmt->bindParam(':comment', $this->comment);

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
                $query = 'DELETE FROM ' . $this->table . ' WHERE comment_id = :comment_id';

            $stmt = $this->conn->prepare($query);

            $this->comment_id = htmlspecialchars(strip_tags($this->comment_id));

            $stmt->bindParam(':comment_id', $this->comment_id);

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

    }