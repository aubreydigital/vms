<?php
    class User {
        private $conn;
        private $table = 'user';

        //User properies
        public $user_id;
        public $user_name;
        public $user_email;
        public $user_password;
        public $full_name;
        public $pronouns;
        public $artist_name;
        public $phone_number;
        public $website;
        public $twitter;
        public $twitch;
        public $soundcloud;
        public $instagram;
        public $status;
        public $created_at;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
                $query = 
                'SELECT u.user_id,
                        u.user_name,
                        u.profile_pic,
                        u.full_name,
                        u.pronouns,
                        u.artist_name,
                        u.user_email,
                        u.phone_number,
                        u.website,
                        u.user_password,
                        u.twitch,
                        u.twitter,
                        u.soundcloud,
                        u.instagram,
                        u.created_at
                FROM
                    ' . $this->table . ' u
                ORDER BY
                    u.created_at DESC';
                
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
                    u.user_id,
                    u.user_name,
                    u.profile_pic,
                    u.user_email,
                    u.created_at,
                    u.full_name,
                    u.pronouns,
                    u.artist_name,
                    u.phone_number,
                    u.website,
                    u.twitch,
                    u.twitter,
                    u.soundcloud,
                    u.instagram,
                    u.created_at
                FROM '
                    . $this->table . ' u
                WHERE
                    u.user_id = ?
                LIMIT 0,1';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind id
            $stmt->bindParam(1, $this->user_id);

            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->user_id = $row['user_id'];
            $this->user_name = $row['user_name'];
            $this->user_email = $row['user_email'];
            $this->profile_pic = $row['profile_pic'];
            $this->full_name = $row['full_name'];
            $this->pronouns = $row['pronouns'];
            $this->artist_name = $row['artist_name'];
            $this->phone_number = $row['phone_number'];
            $this->website = $row['website'];
            $this->twitter = $row['twitter'];
            $this->twitch = $row['twitch'];
            $this->soundcloud = $row['soundcloud'];
            $this->instagram = $row['instagram'];
            
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
                user_email = :user_email,
                profile_pic - :profile_pic,
                user_password = :user_password';
        
            //prepare
            $stmt = $this->conn->prepare($query);

            //sanitize
            $this->user_name = htmlspecialchars(strip_tags($this->user_name));
            $this->profile_pic = htmlspecialchars(strip_tags($this->profile_pic));
            $this->user_email = htmlspecialchars(strip_tags($this->user_email));
            $this->user_password = htmlspecialchars(strip_tags($this->user_password));

            //bind data
            $stmt->bindParam(':user_name', $this->user_name);
            $stmt->bindParam(':profile_pic', $this->profile_pic);
            $stmt->bindParam(':user_email', $this->user_email);
            $stmt->bindParam(':user_password', $this->user_password);

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
                // user_password = :user_password,

                $query = 'UPDATE ' . $this->table . '
            SET
                user_name = :user_name,
                user_email = :user_email,
                profile_pic = :profile_pic,
                full_name = :full_name,
                pronouns = :pronouns,
                artist_name = :artist_name,
                phone_number = :phone_number,
                website = :website,
                twitter = :twitter,
                twitch = :twitch,
                soundcloud = :soundcloud,
                instagram = :instagram
            WHERE
                user_id = :user_id';
            
            $stmt = $this->conn->prepare($query);

            $this->user_name = htmlspecialchars(strip_tags($this->user_name));
            $this->user_email = htmlspecialchars(strip_tags($this->user_email));
            $this->profile_pic = htmlspecialchars(strip_tags($this->profile_pic));
            // $this->user_password = htmlspecialchars(strip_tags($this->user_password));
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            if (isset($_POST['full_name']) && isset($_POST['artist_name']) && isset($_POST['phone_number']) && isset($_POST['website']) && isset($_POST['twitter']) && isset($_POST['twitch']) && isset($_POST['soundcloud']) && isset($_POST['instagram'])) {
            $this->full_name = htmlspecialchars(strip_tags($this->full_name));
            $this->pronouns = htmlspecialchars(strip_tags($this->pronouns));
            $this->artist_name = htmlspecialchars(strip_tags($this->artist_name));
            $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
            $this->website = htmlspecialchars(strip_tags($this->website));
            $this->twitter = htmlspecialchars(strip_tags($this->twitter));
            $this->twitch = htmlspecialchars(strip_tags($this->twitch));
            $this->soundcloud = htmlspecialchars(strip_tags($this->souncloud));
            $this->instagram = htmlspecialchars(strip_tags($this->instagram));
        }
            $stmt->bindParam(':user_name', $this->user_name);
            $stmt->bindParam(':user_email', $this->user_email);
            $stmt->bindParam(':profile_pic', $this->profile_pic);
            // $stmt->bindParam(':user_password', $this->user_password);
            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':full_name', $this->full_name);
            $stmt->bindParam(':pronouns', $this->pronouns);
            $stmt->bindParam(':artist_name', $this->artist_name);
            $stmt->bindParam(':phone_number', $this->phone_number);
            $stmt->bindParam(':website', $this->website);
            $stmt->bindParam(':twitter', $this->twitter);
            $stmt->bindParam(':twitch', $this->twitch);
            $stmt->bindParam(':soundcloud', $this->soundcloud);
            $stmt->bindParam(':instagram', $this->instagram);

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
                $query = 'DELETE FROM ' . $this->table . ' WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($query);

            $this->user_id = htmlspecialchars(strip_tags($this->user_id));

            $stmt->bindParam(':user_id', $this->user_id);

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