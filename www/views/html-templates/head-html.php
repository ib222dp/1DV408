<?php

namespace LoginApp\View;

class HeadHtml {
    private $title;

    public function __construct($title) {
        $this->title = $title;
    }

    public function getHtml() {

        return '
        <head>
            <meta charset="utf-8" />
            <title>' . $this->title . '</title>
            <link rel="stylesheet" type="text/css" href="styles/styles.css" />
            <!-- <script src="scripts/login-app.js"></script> -->
        </head>';
    }
}
