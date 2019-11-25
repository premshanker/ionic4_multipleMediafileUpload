<?php
class Database{
    // specify your own database credentials
    private $db_host = "localhost";
    private $db_username = "root";
    private $db_password = "";
    private $db_name = "gemzkart";
    private $db_conn;
   // get the database connection
    public function getConnection(){
    
        $this->db_conn = null;

        try{
            $this->db_conn = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_username, $this->db_password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->db_conn;
    }
}
?>