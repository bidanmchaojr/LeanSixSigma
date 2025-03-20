<?php
    require_once("DBConn.php");

    class User{
        //Fields
        public $id = 0;
        public $username = "";
        public $password = "";
        public $firstname = "";
        public $lastname = "";
        public $createdate = 0; 
        public $isadmin = 0; 

        function populate($userId){
            $dbconn = new DBConn();
            $dbconn->open();        
            $sql = "SELECT * FROM todo.user where id=".$userId;
            $result = $dbconn->conn->query($sql);
            if(mysqli_num_rows($result) != 0){
                $row = mysqli_fetch_assoc($result);
                $this->id = $userId; 
                $this->username = $row['username'];
                $this->password = $row['password'];
                $this->firstname = $row['firstname'];
                $this->lastname = $row['lastname'];
                $this->createdate = $row['createdate'];
                $this->isadmin = $row['isadmin'];
            }
            $result->free_result();
            $dbconn->close();
        }

        public static function validate_user($uName, $pWord){
            $userId = 0; 
            $sql = "SELECT * FROM todo.user where username='".$uName."' and password='".$pWord."';";
            echo $sql; 
            $dbconn = new DBConn();
            $dbconn->open();   
            $result = $dbconn->conn->query($sql);
            $num_rows = mysqli_num_rows($result);
            if($num_rows > 0){
                $row = mysqli_fetch_assoc($result);
                $userId = $row['id'];
            }
            $result->free_result();
            $dbconn->close();
            return $userId; 
        }

        public static function delete($pId){
            $userId = 0; 
            $sql = "DELETE FROM todo.user where id=".$pId;
            $dbconn = new DBConn();
            $dbconn->open();   
            $dbconn->conn->query($sql);
            $dbconn->close();
        }

        public static function drop_table(){
            $sql = "DROP TABLE todo.test";
            $dbconn = new DBConn();
            $dbconn->open();   
            $dbconn->conn->query($sql);
            $dbconn->close();
        }

        public function insert(){
            $affected_rows = 0; 
            $dbconn = new DBConn();
            $dbconn->open(); 
            $esc_username = $dbconn->conn->real_escape_string($this->username);
            $esc_username = $this->username;
            if(!$dbconn->conn->connect_errno){
                $sql = "INSERT INTO todo.user (username, password, firstname, lastname, createdate, isadmin) values('{$esc_username}','{$this->password}','{$this->firstname}','{$this->lastname}',NOW(),'{$this->isadmin}');";
                if ($dbconn->conn->query($sql)) {
                    //Get ID of new record
                    $this->id = $dbconn->conn->insert_id;
                    $affected_rows = $dbconn->conn->affected_rows;
                } 
            }
            $dbconn->close();
            return $affected_rows;
        }
   
        public function insert_username_password(){

            //Create new instance of DBConn and connect to database.
            $dbconn = new DBConn();
            $dbconn->open(); 
            //Set values for data to be inserted
            $name = "RF Modulator";
            $price = 45607.23; 
            //Create prepared statement to be executed a later time. 
            $statement = $dbconn->conn->prepare("INSERT INTO store.item (name, price) values(?, ?);");
            //Set parameter values. Note that the type must be included.
            // s: string, d: double, i: integer, b: blob
            $statement->bind_param("sd", $name, $price);
            //Execute statement
            $statement->execute(); 
            //Clean up by closing prepared statement & database connection. 
            $statement->close(); 
            $dbconn->close();

        }

        public function update(){
            $affected_rows = 0; 
            $dbconn = new DBConn();
            $dbconn->open(); 
            if(!$dbconn->conn->connect_errno){
                $sql = "UPDATE todo.user SET username='{$this->username}', firstname='{$this->firstname}', lastname='{$this->lastname}', isadmin='{$this->isadmin}' WHERE id ='{$this->id}';";
                if ($dbconn->conn->query($sql)) {
                    $affected_rows = $dbconn->conn->affected_rows; 
                } 
            }
            $dbconn->close();
            return $affected_rows;
        }
    }
?>