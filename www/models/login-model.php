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

        $this->savedCredentials = array('Admin'=>$this->encryptPassword('Password'),
            'User'=>$this->encryptPassword('notell2no1'),
            'Admin2'=>$this->encryptPassword('Password2')); //hard coded login credentials
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
                if ($this->getServersideCookieExpiration($username) > time()) {
                    $_SESSION[$this->sessionNotificationKey] = "Inloggning lyckades via cookies" . ":". $this->getServersideCookieExpiration($username) . "..." . time(); //tf3.3
                    $isSuccess = true;
                } else {
                    $_SESSION[$this->sessionNotificationKey] = "Felaktig information i cookie"; //tf3.5
                }
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
        return isset($_SESSION[$this->sessionAutoLoginKey]) ? $_SESSION[$this->sessionAutoLoginKey] : false;
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

    public function setServersideCookieExpirationIfAutoLogin() {
        if (!$this->isAutoLoginChecked()) return;

        //same as cookie expiration: 30 days (30*24*60*60)
        $expire = time() + 2592000;
        $delimiter = "::-:-::";
        $user = $_SESSION[$this->sessionUsernameKey];
        $newExpirationLine = $user . $delimiter . $expire . PHP_EOL;
        ;
        $filename = "cookieExpirationTimes.txt";
        $lines = array();
        if (file_exists($filename))
            $lines = file($filename);

        $hasMatch = false;
        for ($i = 0; $i < count($lines) - 1; $i++) {
            if (explode($delimiter, $lines[$i])[0] == $user) {
                $lines[$i] = $newExpirationLine;
                $hasMatch = true;
            }
        }
        if (!$hasMatch) {
            array_push($lines, $newExpirationLine);
        }

        $fileHandle = fopen($filename, "w");
        fwrite($fileHandle, implode("", $lines));
        fclose($fileHandle);
    }

    private function getServersideCookieExpiration($username) {
        //TODO: read and return expiration for user

        $delimiter = "::-:-::";
        $filename = "cookieExpirationTimes.txt";

        $lines = array();
        if (file_exists($filename))
            $lines = file($filename);

        $expirationTime = 0;
        foreach ($lines as $line) {
            if (explode($delimiter, $line)[0] == $username)
                $expirationTime = explode($delimiter, trim($line))[1];
        }

        return $expirationTime;
    }
}