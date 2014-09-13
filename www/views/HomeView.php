<?php




class HomeView {

    private $userName;
    private $password;
    private $autoLogin;

    public function renderPage() {
        //Enligt exemplet stor bokstav på månad, men enl svenska skrivregler skrivs månaden med gemen initial, så tar friheten att ändra.
        $dateStr = sprintf("%s, den %d %s år %d. Klockan är [%s:%s:%s].", ucFirst(strftime("%A")) , date("j"), lcFirst(date("F")), date("Y"), date("H"), date("i"), date("s"));
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8" />
            <title>1DV408</title>
            <link rel="stylesheet" type="text/css" href="styles/styles.css" />
        </head>
        <body>
            <h1>Laborationskod hl222ih</h1>
            <p><a href="" onclick="alert(\'Saknar funktionalitet.\n\nFinns bara med för att de fanns med\n\npå bilderna i krav och testfall.\')">Registrera ny användare</a></p>
            <h2>Ej Inloggad</h2>
            <!--reset url-->
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
        <p>' . $dateStr . '</p>
        </body>
        </html>
        ';
    }

}