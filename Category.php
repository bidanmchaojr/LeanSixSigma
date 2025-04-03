<?php
    require_once("DBConn.php");

    class Category{

        public $id;
        public $category; 
        public $code; 

        function populate($categoryId){
            $dbconn = new DBConn();
            $dbconn->open();        
            
            $sql = "SELECT * FROM todo.category where id=?";
            $statement = $dbconn->conn->prepare($sql); 
            $statement->bind_param("i",$categoryId);
            $statement->execute();
            $result = $statement->get_result();

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $this->id = $categoryId;
                $this->category = $row['category'];
                $this->description = $row['description'];
                $this->code = $row['code'];
            }
            $statement->close(); 
            $result->free_result();
            $dbconn->close();
        }

        public static function get_categories(){

            $category_array = array(); 

            $dbconn = new DBConn();
            $dbconn->open();        
            
            $sql = "SELECT * FROM todo.category";
            $statement = $dbconn->conn->prepare($sql); 
            $statement->execute();
            $result = $statement->get_result();

            while($row = $result->fetch_assoc()){

                $category = new Category(); 
                $category->populate($row['id']); 
                array_push($category_array, $category); 
            }

            $statement->close(); 
            $result->free_result();
            $dbconn->close();

            return $category_array; 
        }


    }
?>  