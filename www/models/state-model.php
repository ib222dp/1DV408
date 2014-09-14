<?php

namespace LoginApp\Model;

class State {
    private $loginErrorMessage;
    private $username;
    private $password;
    private $autoLogin;
    private $failedLoginMessage;
    private $savedCredentials;

    public function __construct() {
        $this->savedCredentials = array('Admin'=>'Password');
    }

    public function tryLogin($username, $password, $autoLogin) {
        $isSuccess = false;
        if (!$username) {
            //username not entered 
            //password entered (1.4) or not(1.2), correct(1.4) or not(1.4)
            $this->username = "";
            $this->failedLoginMessage = "Användarnamn saknas. (tf1.2, tf1.4)";
        } else {
            //username entered
            if (!$password) {
                //password not entered
                $this->failedLoginMessage = "Lösenord saknas. (tf1.3)";
            } else {
                //password entered
                if (array_key_exists($username, $this->savedCredentials)) {
                    //username exists
                    $this->username = $username;
                    if ($this->savedCredentials[$username] == $password) {
                        //correct password
                        $this->password = $password;
                        $this->username = $username;
                        $isSuccess = true;
                    } else {
                        //incorrect password
                        $this->password = "";
                        $this->failedLoginMessage = "Felaktigt användarnamn och/eller lösenord. (tf1.5)";
                    }
                } else {
                    //username doesn't exist, password correct or not irrelevant
                    $this->password = "";
                    $this->failedLoginMessage = "Felaktigt användarnamn och/eller lösenord. (tf1.6)";
                }
            }
        }
        return $isSuccess;
    }

    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }

    public function getFailedLoginMessage() {
        return $this->failedLoginMessage;
    }

    public function loginSucceeded() {
        unset($_SESSION['loginErrorMessage']);
    }

    public function loginFailed($loginErrorMessage) {
        $_SESSION['loginErrorMessage'] = $loginErrorMessage;
    }
}