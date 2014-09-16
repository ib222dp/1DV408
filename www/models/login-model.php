<?php

namespace LoginApp\Model;

class LoginModel {
    private $sessionUsernameKey = 'LoginModel::Username';
    private $sessionPasswordKey = 'LoginModel::Password';
    private $sessionAutoLoginKey = 'LoginModel::AutoLogin';
    private $failedLoginMessage;
    private $savedCredentials;

    public function __construct() {
        $this->savedCredentials = array('Admin'=>'Password', 'User'=>'notell2no1'); //hard coded login credentials
    }

    public function tryLogin($username, $password, $autoLogin) {
        $isSuccess = false;
        if (!$username) {
            //username not entered
            //password not entered (tf1.2), password entered (1.4)
            $this->failedLoginMessage = "Användarnamn saknas."; //tf1.2, tf1.4
        } else {
            //username entered
            if (!$password) {
                //password not entered
                $this->failedLoginMessage = "Lösenord saknas."; //tf1.3
            } else {
                //password entered
                if (array_key_exists($username, $this->savedCredentials)) {
                    //username exists
                    if ($this->savedCredentials[$username] == $password) {
                        //correct password
                        $isSuccess = true;
                    } else {
                        //incorrect password
                        $this->failedLoginMessage = "Felaktigt användarnamn och/eller lösenord."; //tf1.5
                    }
                } else {
                    //username doesn't exist, password correct or not irrelevant
                    $this->failedLoginMessage = "Felaktigt användarnamn och/eller lösenord."; //tf1.6
                }
            }
        }
        if ($isSuccess) {
            $_SESSION[$this->sessionUsernameKey] = $username;
            $_SESSION[$this->sessionPasswordKey] = $password;
            $_SESSION[$this->sessionAutoLoginKey] = $autoLogin;
        }
        return $isSuccess;
    }

    public function getUsername() {
        return $_SESSION[$this->sessionUsernameKey];
    }
    public function getPassword() {
        return $_SESSION[$this->sessionPasswordKey];
    }

    public function getFailedLoginMessage() {
        return $this->failedLoginMessage;
    }

    public function isLoggedIn() {
        return (isset($_SESSION[$this->sessionUsernameKey]));
    }
//    public function loginSucceeded() {
//        unset($_SESSION['loginErrorMessage']);
//    }
//
//    public function loginFailed($loginErrorMessage) {
//        $_SESSION['loginErrorMessage'] = $loginErrorMessage;
//    }
}