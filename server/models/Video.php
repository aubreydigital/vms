<?php
    class Video {
        private $conn;
        private $table = 'video';

        //User properies
        public $video_id;
        public $artist_name;
        public $video_name;
        public $file_name;
        public $created_at;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
                $query = 
                'SELECT v.video_id,
                        v.artist_name,
                        v.video_name,
                        v.file_name,
                        v.created_at
                FROM
                    ' . $this->table . ' v
                ORDER BY
                    v.created_at DESC';
                
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
                    v.video_id,
                    v.artist_name,
                    v.video_name,
                    v.file_name,
                    v.created_at
                FROM '
                    . $this->table . ' t
                WHERE
                    v.user_id = ?
                LIMIT 0,1';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind id
            $stmt->bindParam(1, $this->user_id);

            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->video_id = $row['video_id'];
            $this->artist_name = $row['artist_name'];
            $this->video_name = $row['video_name'];
            $this->file_name = $row['file_name'];
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
                artist_name = artist_name
                video_name = :video_name,
                file_name = :file_name';
        
            //prepare
            $stmt = $this->conn->prepare($query);

            //sanitize
            $this->artist_name = htmlspecialchars(strip_tags($this->artist_name));
            $this->video_name = htmlspecialchars(strip_tags($this->video_name));
            $this->file_name = htmlspecialchars(strip_tags($this->file_name));

            //bind data
            $stmt->bindParam(':artist_name', $this->artist_name);
            $stmt->bindParam(':video_name', $this->video_name);
            $stmt->bindParam(':file_name', $this->file_name);

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
                video_name = :video_name,
                file_name = :file_name

            WHERE
                video_id = :video_id';
            
            $stmt = $this->conn->prepare($query);

            $this->video_name = htmlspecialchars(strip_tags($this->video_name));
            $this->file_name = htmlspecialchars(strip_tags($this->file_name));
            
            $stmt->bindParam(':video_name', $this->video_name);
            $stmt->bindParam(':file_name', $this->file_name);

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
                $query = 'DELETE FROM ' . $this->table . ' WHERE video_id = :video_id';

            $stmt = $this->conn->prepare($query);

            $this->video_id = htmlspecialchars(strip_tags($this->video_id));

            $stmt->bindParam(':video_id', $this->video_id);

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