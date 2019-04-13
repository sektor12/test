<?php

class Connection {
    
    public $connection;
    
    public function __construct() {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD) or die('Cannot connect to database.');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setConnection($conn);
    }
    
    private function setConnection($conn) {
        $this->connection = $conn;
    }
    
    public function getConnection() {
        return $this->connection;
    }
}