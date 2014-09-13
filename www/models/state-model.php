<?php

namespace StateModel;

class State {
    private $loginErrorMessage;
    private $username;
    private $password;
    private $autoLogin;
    private $failedLoginMessage;

    public function __construct() {

    }

    public function tryLogin($username, $password, $autoLogin) {
        $isSuccess = false;
        if ($username) {
            $this->username = $username;
            $isSuccess = true;
        } else {
            $this->username = "";
            $this->failedLoginMessage = "Användarnamn saknas.";
        }
        return $isSuccess;
    }

    public function getUsername() {
        return $this->username;
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