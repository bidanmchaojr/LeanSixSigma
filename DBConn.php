<?php

    class DBConn{

        public $conn;

        public function open() {
            $this->conn = new mysqli("localhost", "root", "password", "todo"); 
            //$this->conn = new mysqli("10.4.52.48:3306", "lebron", "password", "todo");
        }
    
        public function close(){
            $this->conn -> close();
        }

    }

?>