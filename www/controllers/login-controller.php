<?php
namespace LoginController;
use LoginView as View;
use StateModel as Model;

require_once("views/home-view.php");
require_once("models/state-model.php");

class LoginController {

    public function __construct() {
        $this->start();
    }

    public function start() {
        $state = new Model\State();
        $homeView = new View\HomeView();
        if ($homeView->isPost()) {
            $loginCredentials = $homeView->getLoginCredentials();
            if ($state->tryLogin($loginCredentials['username'],$loginCredentials['password'],$loginCredentials['autoLogin']))
                $homeView->renderPage("");
            else
                $homeView->renderPage($state->getFailedLoginMessage());
        } else {
            $homeView->renderPage("");
        }
    }
}