<?php

namespace Controllers;

use Snippets\Messages;
use Models\User as userModel;

class User
{
    private $username, $password;
    private $snippets;
    public  $messages = [];
    
    public function __construct() 
    {
        $snippets = new Messages();
        $this->snippets = $snippets::$login;
    }

    /**
     * Initial function for logging user
     * @return $this
     */
    public function login($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        if (!$this->username) {
            $this->messages[] = [
                'text' => $this->snippets['missing_username'],
                'type' => 'error'
            ];
        }
        if (!$this->password) {
            $this->messages[] = [
                'text' => $this->snippets['missing_password'],
                'type' => 'error'
            ];
        }
        if ($this->username && $this->password) {
            $this->checkRegistration();
        }
        return $this;
    }

    /**
     * Checking if user is registered and starting session
     */
    public function checkRegistration()
    {
        $userModel = new userModel();
        if ($userModel->getRegistered($this->username, $this->password)) {
            $this->messages[] = [
                'text' => $this->snippets['loging_successful'],
                'type' => 'success'
            ];
            $_SESSION['uid'] = $userModel->user['id'];
            $_SESSION['username'] = $userModel->user['username'];
            $_SESSION['email'] = $userModel->user['email'];
        } else {
            $this->messages[] = [
                'text' => $this->snippets['wrong_username_or_password'],
                'type' => 'error'
            ];
        }
    }
    
    /**
     * Getting all users
     * @return array
     */
    public function getUsers() : array
    {
        $userModel = new userModel();
        $users = $userModel->getUsers();
        return $users;
    }
}
