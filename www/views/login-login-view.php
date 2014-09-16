<?php

namespace LoginApp\View;

use LoginApp\Model\LoginModel;

class LoginLoginView extends LoginView {
    private $postUsernameKey = 'LoginView::Username';
    private $postPasswordKey = 'LoginView::Password';
    private $postAutoLoginCheckedKey = 'LoginView::AutoLoginChecked';
    private $postLoginButtonKey = 'LoginView::LoginButton';

    public function __construct(LoginModel $model) {
        $this->username = (isset($_POST[$this->postUsernameKey]) ? $_POST[$this->postUsernameKey] : "");
        $this->password = (isset($_POST[$this->postPasswordKey]) ? $_POST[$this->postPasswordKey] : "");
        $this->autoLogin = (isset($_POST[$this->postAutoLoginCheckedKey]) ? true : false);

        parent::__construct($model);
    }
    public function wasLoginButtonClicked() {
        return (($_SERVER['REQUEST_METHOD'] == 'POST')
            && (isset($_POST[$this->postLoginButtonKey])));
    }

    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getAutoLoginChecked() {
        return $this->autoLogin;
    }

    public function renderPage($loginFailedMessage = "") {

        echo '<html>'
        . $this->headHtml->getHtml() .
        '<body>
            <h1>Laborationskod hl222ih</h1>
            <p><a href="" onclick="alert(\'Saknar funktionalitet.\n\nFinns bara med för att det fanns med\n\npå bilderna i krav och testfall.\')">Registrera ny användare</a></p>
            <h2>Ej Inloggad</h2>
            <form method="post">
                <fieldset>
                    <legend>Login - Skriv in användarnamn och lösenord</legend>' .
                ($loginFailedMessage ? '<p>' . $loginFailedMessage . '</p>' : '')
                . ' <label for="userNameId">Användarnamn:</label>
                    <input type="text" name="' . $this->postUsernameKey . '" id="usernameId" value="' . $this->username . '"></input>
                    <label for="passwordId">Lösenord:</label>
                    <input type="password" name="' . $this->postPasswordKey . '" id="passwordId"></input>
                    <label for="autoLoginId">Håll mig inloggad:</label>
                    <input type="checkbox" name="' . $this->postAutoLoginCheckedKey . '" id="autoLoginId"' .
                ($this->autoLogin ? "checked" : "")
                . '></input>
                    <input type="submit" name="' . $this->postLoginButtonKey . '" value="Logga in" />
                </fieldset>
            </form>
            <p></p>' .
            $this->footerHtml->getHtml() .
        '</body>
        </html>
        ';
    }

}