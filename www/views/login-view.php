<?php

namespace LoginApp\View;

use LoginApp\Model\LoginModel;

require_once("html-templates/head-html.php");
require_once("html-templates/footer-html.php");


abstract class LoginView {

    protected $model;
    protected $headHtml;
    protected $footerHtml;

    protected $username;
    protected $password;
    protected $autoLogin;

    protected $cookieUsernameKey;
    protected $cookieEncryptedPasswordKey;

    public function __construct(LoginModel $model) {
        $this->model = $model;
        $this->footerHtml = new FooterHtml();

        $this->cookieUsernameKey = get_class() . '::UsernameKey';
        $this->cookieEncryptedPasswordKey = get_class() . '::EncryptedPasswordKey';
    }

    public function redirectPage() {
        header('location: ' . $_SERVER['PHP_SELF']);
    }

    public function getUsernameFromCookie() {
        return (isset($_COOKIE[$this->cookieUsernameKey]) ? $_COOKIE[$this->cookieUsernameKey] : "");
    }

    public function getEncryptedPasswordFromCookie() {
        return (isset($_COOKIE[$this->cookieEncryptedPasswordKey]) ? $_COOKIE[$this->cookieEncryptedPasswordKey] : "");
    }

    public function clearCookies() {
        unset($_COOKIE[$this->cookieEncryptedPasswordKey]);
        setcookie($this->cookieEncryptedPasswordKey, null, -1, '/');
        unset($_COOKIE[$this->cookieUsernameKey]);
        setcookie($this->cookieUsernameKey, null, -1, '/');
    }


}