<?php
    require_once("DBConn.php");

    class Task{
        //Fields
        public $id;
        public $name;
        public $description;
        public $priority;
        public $timestamp;
        public $user_id;
        public $category_id; 

        function populate($taskId){
            $dbconn = new DBConn();
            $dbconn->open();        
            
            $sql = "SELECT * FROM todo.task where id=?";
            $statement = $dbconn->conn->prepare($sql); 
            $statement->bind_param("i",$taskId);
            $statement->execute();
            $result = $statement->get_result();

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $this->id = $taskId;
                $this->name = $row['name'];
                $this->description = $row['description'];
                $this->priority = $row['priority'];
                $this->timestamp = $row['timestamp'];
                $this->user_id = $row['user_id'];
                $this->category_id = $row['category_id'];
            }
            $statement->close(); 
            $result->free_result();
            $dbconn->close();
        }

        public function insert(){
            $dbconn = new DBConn();
            $dbconn->open();        
            
            $sql = "INSERT INTO todo.task (name, description, category_id, priority, timestamp, user_id) VALUES (?, ?, ?, ?, NOW(), ?)";
            $statement = $dbconn->conn->prepare($sql); 
            $statement->bind_param("ssiii",$this->name, $this->description, $this->category_id, $this->priority, $this->user_id);
            
            $affected_rows = 0; 
            
            if($statement->execute()){
                //Get ID of new record
                $this->id = $dbconn->conn->insert_id; 
                $affected_rows = $dbconn->conn->affected_rows;
            }

            $statement->close(); 
            $dbconn->close();
            return $affected_rows;
        }

        public function update(){
            $dbconn = new DBConn();
            $dbconn->open();        
            
            $sql = "UPDATE todo.task SET name = ?, description = ?, category_id = ?, priority = ? WHERE id = ?";
            $statement = $dbconn->conn->prepare($sql); 
            $statement->bind_param("ssiii", $this->name, $this->description, $this->category_id, $this->priority, $this->id);
            
            $affected_rows = 0; 
            
            if($statement->execute()){
                $affected_rows = $dbconn->conn->affected_rows;
            }

            $statement->close(); 
            $dbconn->close();
            return $affected_rows;
        }

        public static function delete($task_id){
            $dbconn = new DBConn();
            $dbconn->open();        
            
            $sql = "DELETE FROM todo.task WHERE id = ?";
            $statement = $dbconn->conn->prepare($sql); 
            $statement->bind_param("i", $task_id);
            
            $affected_rows = 0; 
            
            if($statement->execute()){
                $affected_rows = $dbconn->conn->affected_rows;
            }

            $statement->close(); 
            $dbconn->close();
            return $affected_rows;
        }

        public static function delete2(){
            $dbconn = new DBConn();
            $dbconn->open();        
            
            $sql = "DELETE FROM todo.test";
            $statement = $dbconn->conn->prepare($sql); 

            if($statement->execute()){
                echo $dbconn->conn->affected_rows;
            }

            $statement->close(); 
            $dbconn->close();

        }

        public static function get_user_tasks($user_id){

            $task_array = array(); 

            $dbconn = new DBConn();
            $dbconn->open();        
            
            $sql = "SELECT * FROM todo.task where user_id=?";
            $statement = $dbconn->conn->prepare($sql); 
            $statement->bind_param("i",$user_id);
            $statement->execute();
            $result = $statement->get_result();

            while($row = $result->fetch_assoc()){

                $task = new Task(); 
                $task->populate($row['id']); 
                array_push($task_array, $task); 
            }

            $statement->close(); 
            $result->free_result();
            $dbconn->close();

            return $task_array; 
        }



    }
?>