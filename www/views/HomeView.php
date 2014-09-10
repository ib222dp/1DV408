<?php

class HomeView {

    public function renderPage() {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset=\"utf-8\" />
            <title>1DV408</title>
            <link rel=\"stylesheet\" type=\"text/css\" href=\"styles/styles.css\" />
        </head>
        <body>
            hello world (åäö)
        </body>
        </html>
        ";
    }

}