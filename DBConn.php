<?php

    class DBConn{

        public $conn;

        public function open() {
            $this->conn = new mysqli("localhost", "root", "password", "todo"); 
        }
    
        public function close(){
            $this->conn -> close();
        }

    }

?>