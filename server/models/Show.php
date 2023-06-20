<?php
    class Show {
        private $conn;
        private $table = 'shows';

        //User properies
        public $show_id;
        public $flyer;
        public $artists;
        public $venue;
        public $address;
        public $date;
        public $over21;
        public $presaleCost;
        public $cost;
        public $created_at;
        public $tickets;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
                $query = 
                'SELECT s.show_id,
                        s.flyer,
                        s.artists,
                        s.venue,
                        s.address,
                        s.date,
                        s.over21,
                        s.cost,
                        s.presaleCost,
                        s.created_at,
                        s.tickets
                FROM
                    ' . $this->table . ' s
                ORDER BY
                    s.created_at ASC';
                
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
                        s.show_id,
                        s.flyer,
                        s.artists,
                        s.venue,
                        s.address,
                        s.date,
                        s.over21,
                        s.cost,
                        s.presaleCost,
                        s.created_at,
                        s.tickets
                FROM '
                    . $this->table . ' s
                WHERE
                    s.show_id = ?
                LIMIT 0,1';
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //bind id
            $stmt->bindParam(1, $this->user_id);

            //execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->show_id = $row['show_id'];
            $this->flyer = $row['flyer'];
            $this->artists = $row['artists'];
            $this->venue = $row['venue'];
            $this->address = $row['address'];
            $this->date = $row['date'];
            $this->over21 = $row['over21'];
            $this->cost = $row['cost'];
            $this->presaleCost = $row['presaleCost'];
            $this->created_at = $row['created_at'];
            $this->tickets = $row['tickets'];
            
        }

        public function create() {
            // $headers = apache_request_headers();
            // if(isset($headers['Authorization'])):
            // $token = str_replace('Bearer ', '', $headers['Authorization']);
            // try {
            //     $token = JWT::decode($token, $this->key, array('HS512'));
                $query = 'INSERT INTO ' . $this->table . '
            SET
                flyer = :flyer,
                artists = :artists,
                venue = :venue,
                address = :address,
                date = :date,
                cost = :cost,
                presaleCost = :presaleCost,
                over21 = :over21,
                tickets = :tickets';
        
            //prepare
            $stmt = $this->conn->prepare($query);

            //sanitize
            $this->flyer = htmlspecialchars(strip_tags($this->flyer));
            $this->artists = htmlspecialchars(strip_tags($this->artists));
            $this->venue = htmlspecialchars(strip_tags($this->venue));
            $this->address = htmlspecialchars(strip_tags($this->title));
            $this->date = htmlspecialchars(strip_tags($this->date));
            $this->over21 = htmlspecialchars(strip_tags($this->over21));
            $this->cost = htmlspecialchars(strip_tags($this->cost));
            $this->presaleCost = htmlspecialchars(strip_tags($this->presaleCost));
            $this->tickets = htmlspecialchars(strip_tags($this->tickets));

            //bind data
            $stmt->bindParam(':flyer', $this->flyer);
            $stmt->bindParam(':artists', $this->artists);
            $stmt->bindParam(':venue', $this->venue);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':date', $this->date);
            $stmt->bindParam(':over21', $this->over21);
            $stmt->bindParam(':cost', $this->cost);
            $stmt->bindParam(':presaleCost', $this->presaleCost);
            $stmt->bindParam(':tickets', $this->tickets);

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
                flyer = :flyer,
                artists = :artists,
                venue = :venue,
                address = :address,
                date = :date,
                over21 = :over21,
                cost = :cost,
                presaleCost = :presaleCost,
                tickets = :tickets

            WHERE
                show_id = :show_id';
            
            $stmt = $this->conn->prepare($query);

            $this->flyer = htmlspecialchars(strip_tags($this->flyer));
            $this->artists = htmlspecialchars(strip_tags($this->artists));
            $this->venue = htmlspecialchars(strip_tags($this->venue));
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->date = htmlspecialchars(strip_tags($this->date));
            $this->over21 = htmlspecialchars(strip_tags($this->over21));
            $this->cost = htmlspecialchars(strip_tags($this->cost));
            $this->presaleCost = htmlspecialchars(strip_tags($this->presaleCost));
            $this->tickets = htmlspecialchars(strip_tags($this->tickets));
            
            $stmt->bindParam(':flyer', $this->flyer);
            $stmt->bindParam(':artists', $this->artists);
            $stmt->bindParam(':venue', $this->venue);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':date', $this->date);
            $stmt->bindParam(':over21', $this->over21);
            $stmt->bindParam(':cost', $this->cost);
            $stmt->bindParam(':presaleCost', $this->presaleCost);
            $stmt->bindParam(':tickets', $this->tickets);

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
                $query = 'DELETE FROM ' . $this->table . ' WHERE show_id = :show_id';

            $stmt = $this->conn->prepare($query);

            $this->show_id = htmlspecialchars(strip_tags($this->show_id));

            $stmt->bindParam(':show_id', $this->show_id);

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