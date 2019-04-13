<?php

namespace Models;

use Connection;

class User
{
    private $connection;
    public $user;
    
    public function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->getConnection();
    }
    
    /**
     * Checking if user is registered
     * 
     * @param type $username
     * @param type $password
     * @return bool
     */
    public function getRegistered($username, $password) : bool
    {
        $password = md5($password);
        $query = 'SELECT * FROM users WHERE username=? AND password=?';
        $qPrep = $this->connection->prepare($query);
        $qPrep->execute([$username, $password]);
        $results = $qPrep->fetchAll();
        if (!empty($results)) {
            $this->user = $results[0];
        }

        if (!empty($results)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getUsers() : array
    {
        $query = 'SELECT * FROM users';
        $qPrep = $this->connection->prepare($query);
        $qPrep->execute();
        $results = $qPrep->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }
}
