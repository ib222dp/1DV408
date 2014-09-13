<?php

namespace LoginView;

require_once("html_templates/HeadHtml.php");
require_once("html_templates/FooterHtml.php");



class HomeView {

    private $userName;
    private $password;
    private $autoLogin;

    public function renderPage() {
        $headHtml = new HeadHtml('1DV408 - Login');
        $footerHtml = new FooterHtml();


        echo $headHtml->getHtml() . '
        <body>
            <h1>Laborationskod hl222ih</h1>
            <p><a href="" onclick="alert(\'Saknar funktionalitet.\n\nFinns bara med för att de fanns med\n\npå bilderna i krav och testfall.\')">Registrera ny användare</a></p>
            <h2>Ej Inloggad</h2>
            <form method="post">
                <fieldset>
                    <legend>Login - Skriv in användarnamn och lösenord</legend>
                    <label for="userNameId">Användarnamn:</label>
                    <input type="text" name="HomeView::UserName" id="userNameId"></input>
                    <label for="passwordId">Lösenord:</label>
                    <input type="password" name="HomeView::Password" id="passwordId"></input>
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