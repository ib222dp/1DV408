<?php
namespace LoginApp\Controller;
use LoginApp\View as View;
use LoginApp\Model as Model;

require_once("views/home-view.php");
require_once("models/state-model.php");

class LoginController {

    public function __construct() {
    }

    public function start() {
        $state = new Model\State();
        $homeView = new View\HomeView();
        if ($homeView->isPost()) {
            $loginCredentials = $homeView->getLoginCredentials();
            if ($state->tryLogin($loginCredentials['username'],$loginCredentials['password'],$loginCredentials['autoLogin']))
                $homeView->renderPage(true, "");
            else
                $homeView->renderPage(false, $state->getFailedLoginMessage());
        } else {
            $homeView->renderPage(false, "");
        }
    }
}