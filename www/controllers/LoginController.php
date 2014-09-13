<?php
namespace LoginController;
use LoginView as View;

require_once("views/HomeView.php");

class LoginController {

    public function __construct() {
        $this->start();
    }

    public function start() {
        $homeView = new View\HomeView();
        $homeView->renderPage();
    }
}