<?php

namespace LoginApp\View;

require_once("html-templates/head-html.php");
require_once("html-templates/footer-html.php");



class LoginView {

    const PostUsernameKey = 'LoginView::Username';
    const PostPasswordKey = 'LoginView::Password';
    const PostAutoLoginCheckedKey = 'LoginView::AutoLoginChecked';
    const PostLoginButtonKey = 'LoginView::LoginButton';

    private $username;
    private $password;
    private $autoLogin;

    public function __construct() {
        $this->username = (isset($_POST[self::PostUsernameKey]) ? $_POST[self::PostUsernameKey] : "");
        $this->password = (isset($_POST[self::PostPasswordKey]) ? $_POST[self::PostPasswordKey] : "");
        $this->autoLogin = (isset($_POST[self::PostAutoLoginCheckedKey]) ? true : false);
    }
    public function wasLoginButtonClicked() {
        return (($_SERVER['REQUEST_METHOD'] == 'POST')
            && (isset($_POST[self::PostLoginButtonKey])));
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
                    <input type="text" name="' . self::PostUsernameKey . '" id="usernameId"></input>
                    <label for="passwordId">Lösenord:</label>
                    <input type="password" name="' . self::PostPasswordKey . '" id="passwordId"></input>
                    <label for="autoLoginId">Håll mig inloggad:</label>
                    <input type="checkbox" name="' . self::PostAutoLoginCheckedKey . '" id="autoLoginId"' .
                ($this->autoLogin ? "checked" : "")
                . '></input>
                    <input type="submit" name="' . self::PostLoginButtonKey . '" value="Logga in" />
                </fieldset>
            </form>
            <p></p>' .
            $footerHtml->getHtml() .
        '</body>
        </html>
        ';
    }

}