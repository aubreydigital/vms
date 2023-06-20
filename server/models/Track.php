<?php
    class Track {
        private $conn;
        private $table = 'tracks';

        //User properies
        public $track_id;
        public $artist_name;
        public $track_name;
        public $file_name;
        public $image;
        public $created_at;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
                $query = 
                'SELECT t.track_id,
                        t.artist_name,
                        t.track_name,
                        t.file_name,
                        t.image,
                        t.created_at
                FROM
                    ' . $this->table . ' t
                ORDER BY
                    t.created_at DESC';
                
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
                    t.track_id,
                    t.artist_name,
                    t.track_name,
                    t.file_name,
                    t.image,
                    t.created_at
                FROM '
                    . $this->table . ' t
                WHERE
                    t.user_id = ?
                LIMIT 0,1';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind id
            $stmt->bindParam(1, $this->user_id);

            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->track_id = $row['track_id'];
            $this->artist_name = $row['artist_name'];
            $this->track_name = $row['track_name'];
            $this->file_name = $row['file_name'];
            $this->image = $row['image'];
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
                track_name = :track_name,
                image = image,
                file_name = :file_name';
        
            //prepare
            $stmt = $this->conn->prepare($query);

            //sanitize
            $this->artist_name = htmlspecialchars(strip_tags($this->artist_name));
            $this->track_name = htmlspecialchars(strip_tags($this->track_name));
            $this->file_name = htmlspecialchars(strip_tags($this->file_name));
            $this->image = htmlspecialchars(strip_tags($this->image));

            //bind data
            $stmt->bindParam(':artist_name', $this->artist_name);
            $stmt->bindParam(':track_name', $this->track_name);
            $stmt->bindParam(':file_name', $this->file_name);
            $stmt->bindParam(':image', $this->image);

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
                track_name = :track_name,
                file_name = :file_name,
                image = :image

            WHERE
                track_id = :track_id';
            
            $stmt = $this->conn->prepare($query);

            $this->track_name = htmlspecialchars(strip_tags($this->track_name));
            $this->file_name = htmlspecialchars(strip_tags($this->file_name));
            $this->image = htmlspecialchars(strip_tags($this->image));
            
            $stmt->bindParam(':track_name', $this->track_name);
            $stmt->bindParam(':file_name', $this->file_name);
            $stmt->bindParam(':image', $this->image);

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
                $query = 'DELETE FROM ' . $this->table . ' WHERE track_id = :track_id';

            $stmt = $this->conn->prepare($query);

            $this->track_id = htmlspecialchars(strip_tags($this->track_id));

            $stmt->bindParam(':track_id', $this->track_id);

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