<?php

namespace LoginView;

require_once("html-templates/head-html.php");
require_once("html-templates/footer-html.php");



class HomeView {

    private $userName;
    private $password;
    private $autoLogin;
    private $postUsernameKey;
    private $postPasswordKey;

    public function __construct() {
        $this->postUsernameKey = 'HomeView::Username';
        $this->postPasswordKey = 'HomeView::Password';
    }
    public function isPost() {
        return !empty($_POST);
    }
    public function getLoginCredentials() {
        $loginCredentials = array(
           'username'=>(isset($_POST[$this->postUsernameKey]) ? $_POST[$this->postUsernameKey] : ""),
           'password'=>(isset($_POST['HomeView::Password']) ? $_POST['HomeView::Password'] : ""),
           'autoLogin'=>(isset($_POST['HomeView::AutoLoginChecked']) ? true : false)
        );
        return $loginCredentials;
    }
    public function renderPage($loginFailedMessage) {
        $headHtml = new HeadHtml('1DV408 - Login');
        $footerHtml = new FooterHtml();
        echo $headHtml->getHtml() . '
        <body>
            <h1>Laborationskod hl222ih</h1>
            <p><a href="" onclick="alert(\'Saknar funktionalitet.\n\nFinns bara med för att de fanns med\n\npå bilderna i krav och testfall.\')">Registrera ny användare</a></p>
            <h2>Ej Inloggad</h2>
            <form method="post">
                <fieldset>
                    <legend>Login - Skriv in användarnamn och lösenord</legend>' .
                    ($loginFailedMessage ? '<p>' . $loginFailedMessage . '</p>' : '')
                    . ' <label for="userNameId">Användarnamn:</label>
                    <input type="text" name="' . $this->postUsernameKey . '" id="usernameId"></input>
                    <label for="passwordId">Lösenord:</label>
                    <input type="password" name="' . $this->postPasswordKey . '" id="passwordId"></input>
                    <label for="autoLoginId">Håll mig inloggad:</label>
                    <input type="checkbox" name="HomeView::AutoLoginChecked" id="autoLoginId"' .
                        ($this->autoLogin ? "checked" : "")
                        . '></input>
                    <input type="submit" value="Logga in" />
                </fieldset>
            </form>
            <p></p>' .
            $footerHtml->getHtml()
        . ' </body>
        </html>
        ';
    }

}