<?php

class DatabaseConnection
{
    public function __construct()
    {
        $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            $this->conn = $conn;
        }
    }

    public function connect(){
        $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            return $this->conn = $conn;
        }
    }
}


?>