<?php

namespace LoginApp\Model;

class LoginModel {
    private $sessionUsernameKey;
    private $sessionPasswordKey;
    private $sessionAutoLoginKey;
    private $sessionIsLoggedInKey;
    private $sessionNotificationKey;

    private $savedCredentials;

    public function __construct() {

        $this->sessionUsernameKey = get_class() . '::Username';
        $this->sessionPasswordKey = get_class() . '::Password';
        $this->sessionAutoLoginKey = get_class() . '::AutoLogin';
        $this->sessionIsLoggedInKey = get_class() . '::IsLoggedIn';
        $this->sessionNotificationKey = get_class() . '::NotificationKey';

        $this->savedCredentials = array('Admin'=>'Password', 'User'=>'notell2no1'); //hard coded login credentials
    }

    public function logout() {
        $_SESSION[$this->sessionNotificationKey] = "Du har nu loggat ut";
        unset($_SESSION[$this->sessionUsernameKey]);
        unset($_SESSION[$this->sessionIsLoggedInKey]);
    }
    public function tryLogin($username, $password, $autoLogin) {
        $isSuccess = false;
        if (!$username) {
            //username not entered
            //password not entered (tf1.2), password entered (1.4)
            $_SESSION[$this->sessionNotificationKey] = "Användarnamn saknas"; //tf1.2, tf1.4
        } else {
            //username entered
            if (!$password) {
                //password not entered
                $_SESSION[$this->sessionNotificationKey] = "Lösenord saknas"; //tf1.3
            } else {
                //password entered
                if (array_key_exists($username, $this->savedCredentials)) {
                    //username exists
                    if ($this->savedCredentials[$username] == $password) {
                        //correct password
                        $_SESSION[$this->sessionNotificationKey] = "Inloggning lyckades"; //tf1.7
                        $isSuccess = true;
                    } else {
                        //incorrect password
                        $_SESSION[$this->sessionNotificationKey] = "Felaktigt användarnamn och/eller lösenord"; //tf1.5
                    }
                } else {
                    //username doesn't exist, password correct or not irrelevant
                    $_SESSION[$this->sessionNotificationKey] = "Felaktigt användarnamn och/eller lösenord"; //tf1.6
                }
            }
        }
        $_SESSION[$this->sessionUsernameKey] = $username;

        if ($isSuccess) {
            $_SESSION[$this->sessionIsLoggedInKey] = true;
            $_SESSION[$this->sessionPasswordKey] = $password;
            $_SESSION[$this->sessionAutoLoginKey] = $autoLogin;
        } else {
            unset($_SESSION[$this->sessionIsLoggedInKey]);
        }
        return $isSuccess;
    }

    public function getUsername() {
        return isset($_SESSION[$this->sessionUsernameKey]) ? $_SESSION[$this->sessionUsernameKey] : "";
    }

    public function getNotification() {
        return (isset($_SESSION[$this->sessionNotificationKey]) ? $_SESSION[$this->sessionNotificationKey] : "");
    }
    public function unsetNotification() {
        if (isset($_SESSION[$this->sessionNotificationKey]))
            unset($_SESSION[$this->sessionNotificationKey]);
    }
    public function isLoggedIn() {
        return (isset($_SESSION[$this->sessionIsLoggedInKey]));
    }
}