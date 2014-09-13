<?php
namespace LoginController;
use LoginView as View;
use StateModel as Model;

require_once("views/home-view.php");

class LoginController {

    public function __construct() {
        $this->start();
    }

    public function start() {
        $homeView = new View\HomeView();
        $homeView->renderPage("Användarnamn saknas.");
    }
}