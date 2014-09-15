<?php

namespace LoginApp\View;

require_once("html-templates/head-html.php");
require_once("html-templates/footer-html.php");



class LoginView {

    private $postUsernameKey = 'LoginView::Username';
    private $postPasswordKey = 'LoginView::Password';
    private $postAutoLoginCheckedKey = 'LoginView::AutoLoginChecked';
    private $postLoginButtonKey = 'LoginView::LoginButton';

    private $username;
    private $password;
    private $autoLogin;

    public function __construct() {
        $this->username = (isset($_POST[$this->postUsernameKey]) ? $_POST[$this->postUsernameKey] : "");
        $this->password = (isset($_POST[$this->postPasswordKey]) ? $_POST[$this->postPasswordKey] : "");
        $this->autoLogin = (isset($_POST[$this->postAutoLoginCheckedKey]) ? true : false);
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
    public function renderPage($isLoggedIn, $loginFailedMessage) {
        $headHtml = new HeadHtml('1DV408 - Login');
        $footerHtml = new FooterHtml();
        echo '<html>'
        . $headHtml->getHtml() .
        '<body>
            <h1>Laborationskod hl222ih</h1>
            <p><a href="" onclick="alert(\'Saknar funktionalitet.\n\nFinns bara med för att de fanns med\n\npå bilderna i krav och testfall.\')">Registrera ny användare</a></p>
            <h2>' . ($isLoggedIn ? $this->username . ' är inloggad' : 'Ej Inloggad') . '</h2>
            <form method="post">
                <fieldset>
                    <legend>Login - Skriv in användarnamn och lösenord</legend>' .
                ($loginFailedMessage ? '<p>' . $loginFailedMessage . '</p>' : '')
                . ' <label for="userNameId">Användarnamn:</label>
                    <input type="text" name="' . $this->postUsernameKey . '" id="usernameId"></input>
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
            $footerHtml->getHtml() .
        '</body>
        </html>
        ';
    }

}