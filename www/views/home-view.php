<?php

namespace LoginApp\View;

require_once("html-templates/head-html.php");
require_once("html-templates/footer-html.php");



class HomeView {

    private $username;
    private $password;
    private $autoLogin;
    private $postUsernameKey;
    private $postPasswordKey;
    private $postAutoLoginChecked;

    public function __construct() {
        $this->postUsernameKey = 'HomeView::Username';
        $this->postPasswordKey = 'HomeView::Password';
        $this->postAutoLoginChecked = 'HomeView::AutoLoginChecked';
        $this->username = (isset($_POST[$this->postUsernameKey]) ? $_POST[$this->postUsernameKey] : "");
        $this->password = (isset($_POST[$this->postPasswordKey]) ? $_POST[$this->postPasswordKey] : "");
        $this->autoLogin = (isset($_POST[$this->postAutoLoginChecked]) ? true : false);
    }
    public function isPost() {
        return !empty($_POST);
    }
    public function getLoginCredentials() {
        $loginCredentials = array(
           'username'=>$this->username,
           'password'=>$this->password,
           'autoLogin'=>$this->autoLogin
        );
        return $loginCredentials;
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
                    <input type="checkbox" name="' . $this->postAutoLoginChecked . '" id="autoLoginId"' .
                ($this->autoLogin ? "checked" : "")
                . '></input>
                    <input type="submit" value="Logga in" />
                </fieldset>
            </form>
            <p></p>' .
            $footerHtml->getHtml() .
        '</body>
        </html>
        ';
    }

}