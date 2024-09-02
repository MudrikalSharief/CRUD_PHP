<?php
        /*Create a class to connect data base */
    class Database{
            /*This variale below hold the value of each */
            private $host = "localhost";    
            private $username = "root";
            private $password = "";
            private $dbname = "sample_db";

            /* This variable will hold the connection */
            protected $conn;
            
            /* This Function will ceate a connection if there are no connection */
            function connect(){
                if($this->conn === null){
                        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
                }

                return $this->conn;//return the connection
            }

    }

   // $obj = new Database();
    //$obj->connect();

