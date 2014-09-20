<?php

namespace LoginApp\Model;

class LoginModel {
    private $sessionUsernameKey;
    private $sessionAutoLoginKey;
    private $sessionIsLoggedInKey;
    private $sessionNotificationKey;

    private $savedCredentials;

    public function __construct() {

        $this->sessionUsernameKey = get_class() . '::Username';
        $this->sessionAutoLoginKey = get_class() . '::AutoLogin';
        $this->sessionIsLoggedInKey = get_class() . '::IsLoggedIn';
        $this->sessionNotificationKey = get_class() . '::NotificationKey';

        $this->savedCredentials = array('Admin'=>$this->encryptPassword('Password'), 'User'=>$this->encryptPassword('notell2no1')); //hard coded login credentials
    }

    public function encryptPassword($password) {
        //If switching ip frequently, browsers user agent would be a more stable salt, still
        //not using same salt for all users decreasing security and
        //not using random salt which then needs to be stored increasing complexity.
        //Not sure about the security of the md5 choice for encryption.
        $salt = $_SERVER['HTTP_USER_AGENT'];
        return md5($salt.$password);
    }
    public function logout() {
        $_SESSION[$this->sessionNotificationKey] = "Du har nu loggat ut";
        unset($_SESSION[$this->sessionUsernameKey]);
        unset($_SESSION[$this->sessionIsLoggedInKey]);
    }
    public function tryLoginWithCookie($username, $encryptedPassword) {
        $isSuccess = false;

        if (array_key_exists($username, $this->savedCredentials)) {
            //username-cookie exists
            if ($this->savedCredentials[$username] == $encryptedPassword) {
                //valid password-cookie
                $_SESSION[$this->sessionNotificationKey] = "Inloggning lyckades via cookies"; //tf3.3
                $isSuccess = true;
            } else {
                //invalid password-cookie
                $_SESSION[$this->sessionNotificationKey] = "Felaktig information i cookie"; //tf3.4
            }
        } else {
            //$_SESSION[$this->sessionNotificationKey] = "Felaktig information i cookie"; //tf3.4
        }
        $_SESSION[$this->sessionUsernameKey] = $username;

        if ($isSuccess) {
            $_SESSION[$this->sessionIsLoggedInKey] = true;
        } else {
            unset($_SESSION[$this->sessionIsLoggedInKey]);
        }
        return $isSuccess;
    }

    public function tryLogin($username, $password, $autoLogin) {
        $encryptedPassword = $this->encryptPassword($password);
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
                    if ($this->savedCredentials[$username] == $encryptedPassword) {
                        //correct password
                        if ($autoLogin) {
                            $_SESSION[$this->sessionNotificationKey] = "Inloggning lyckades och vi kommer ihåg dig nästa gång"; //tf3.1
                        } else {
                            $_SESSION[$this->sessionNotificationKey] = "Inloggning lyckades"; //tf1.7
                        }
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
            $_SESSION[$this->sessionAutoLoginKey] = $autoLogin;
        } else {
            unset($_SESSION[$this->sessionIsLoggedInKey]);
        }
        return $isSuccess;
    }

    public function getUsername() {
        return isset($_SESSION[$this->sessionUsernameKey]) ? $_SESSION[$this->sessionUsernameKey] : "";
    }

    public function isAutoLoginChecked() {
        return isset($_SESSION[$this->sessionAutoLoginKey]);
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

    public function setServersideCookieExpiration() {

    }
}