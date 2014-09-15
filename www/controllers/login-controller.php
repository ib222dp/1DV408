<?php
namespace LoginApp\Controller;
use LoginApp\View as View;
use LoginApp\Model as Model;

require_once("views/login-view.php");
require_once("models/login-model.php");

class LoginController {
    private $view;
    private $model;

    public function __construct() {
        $this->model = new Model\LoginModel();
        $this->view = new View\LoginView();
    }

    public function start() {
        if ($this->view->wasLoginButtonClicked()) {
            $loginCredentials = $this->view->getLoginCredentials();
            if ($this->model->tryLogin($loginCredentials['username'],$loginCredentials['password'],$loginCredentials['autoLogin']))
                $this->view->renderPage(true, "");
            else
                $this->view->renderPage(false, $this->model->getFailedLoginMessage());
        } else {
            $this->view->renderPage(false, "");
        }
    }
}