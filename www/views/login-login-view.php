<?php

namespace LoginApp\View;

use LoginApp\Model\LoginModel;

class LoginLoginView extends LoginView {
    private $postUsernameKey;
    private $postPasswordKey;
    private $postAutoLoginCheckedKey;
    private $postLoginButtonNameKey;

    public function __construct(LoginModel $model) {
        $this->postUsernameKey = get_class() . '::Username';
        $this->postPasswordKey = get_class() . '::Password';
        $this->postAutoLoginCheckedKey = get_class() . '::AutoLoginChecked';
        $this->postLoginButtonNameKey = get_class() . '::LoginButtonName';

        $this->username = (isset($_POST[$this->postUsernameKey]) ? $_POST[$this->postUsernameKey] : "");
        $this->password = (isset($_POST[$this->postPasswordKey]) ? $_POST[$this->postPasswordKey] : "");
        $this->autoLogin = (isset($_POST[$this->postAutoLoginCheckedKey]) ? true : false);

        parent::__construct($model);

        $this->headHtml = new HeadHtml('1DV408 - Login');

    }

    public function wasLoginButtonClicked() {
        return isset($_POST[$this->postLoginButtonNameKey]);
    }

    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    public function wasAutoLoginChecked() {
        return $this->autoLogin;
    }

    public function doesLoginCookieExist() {
        return ((isset($_COOKIE[$this->cookieUsernameKey]) || (isset($_COOKIE[$this->cookieEncryptedPasswordKey]))));
    }
    public function renderPage() {
        if (isset($_COOKIE[$this->cookieEncryptedPasswordKey])) {
            // TODO: something
        }
        echo '<html>'
        . $this->headHtml->getHtml() .
        '<body>
            <h1>Laborationskod hl222ih</h1>
            <p><a href="" onclick="alert(\'Saknar funktionalitet.\n\nFinns bara med för att det fanns med\n\npå bilderna i krav och testfall.\')">Registrera ny användare</a></p>
            <h2>Ej Inloggad</h2>

            <form action="' . $_SERVER['PHP_SELF'] . '" method="post">
                <fieldset>
                    <legend>Login - Skriv in användarnamn och lösenord</legend>' .
                ($this->model->getNotification() ? '<p>' . $this->model->getNotification() . '</p>' : '')
                . ' <label for="usernameId">Användarnamn:</label>
                    <input type="text" name="' . $this->postUsernameKey . '" id="usernameId" value="' . $this->model->getUsername() . '" autofocus />
                    <label for="passwordId">Lösenord:</label>
                    <input type="password" name="' . $this->postPasswordKey . '" id="passwordId" />
                    <label for="autoLoginId">Håll mig inloggad:</label>
                    <input type="checkbox" name="' . $this->postAutoLoginCheckedKey . '" id="autoLoginId"' .
                ($this->autoLogin ? "checked" : "") . ' />
                    <input type="submit" name="' . $this->postLoginButtonNameKey . '" value="Logga in" />
                </fieldset>
            </form>
            <p></p>' .
            $this->footerHtml->getHtml() .
        '</body>
        </html>
        ';
    }
    public function setCookiesIfAutoLogin() {
        if ($this->autoLogin) {
            $encryptedPassword = $this->model->encryptPassword($_POST[$this->postPasswordKey]);
            setcookie($this->cookieUsernameKey, $_POST[$this->postUsernameKey], time()+2592000, '/'); //expire in 30 days
            setcookie($this->cookieEncryptedPasswordKey, $encryptedPassword, time()+2592000, '/');
        }
    }
}