<?php

namespace LoginApp\View;

use LoginApp\Model\LoginModel;

class LoggedInLoginView extends LoginView {

    public function __construct(LoginModel $model) {
        parent::__construct($model);
    }

    public function renderPage() {

        echo '<html>'
        . $this->headHtml->getHtml() .
        '<body>
            <h1>Laborationskod hl222ih</h1>
            <h2>' . $this->model->getUsername() . ' är inloggad' . '</h2>
            <p><a href="" onclick="">Logga ut</a></p>
            <p></p>' .
            $this->footerHtml->getHtml() .
        '</body>
        </html>
        ';
    }

}