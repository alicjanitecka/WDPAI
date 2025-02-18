<?php

require_once "config.php";

class DatabaseConnector {
    private $username;
    private $password;
    private $host;
    private $database;

    public function __construct()
    {
        $this->username = USERNAME;
        $this->password = PASSWORD;
        $this->host = HOST;
        $this->database = DATABASE;
    }

    public function connect()
    {
        try {
            // echo "Attempting to connect to database...<br>";
            // echo "Host: $this->host<br>";
            // echo "Database: $this->database<br>";
            // echo "Username: $this->username<br>";
            $conn = new PDO(
                "pgsql:host=$this->host;port=5432;dbname=$this->database",
                $this->username,
                $this->password
            );
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connection successful!<br>";
            return $conn;
        }
        catch(PDOException $e) {
            //TODO return error page
            die("Connection failed: " . $e->getMessage());
        }
    }


    //TODO disconnect
}