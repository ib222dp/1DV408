<?php
namespace LoginApp\Controller;
use LoginApp\View as View;
use LoginApp\Model as Model;

require_once("models/login-model.php");
require_once("views/login-view.php");
require_once("views/login-login-view.php");
require_once("views/logged-in-login-view.php");

class LoginController {
    private $view;
    private $model;

    public function __construct() {
        $this->model = new Model\LoginModel();
    }

    public function start() {
        if ($this->model->isLoggedIn()) {
            $this->view = new View\LoggedInLoginView($this->model);
            if ($this->view->wasLogoutLinkClicked()) {
                $this->model->logout();
                $this->view->clearCookies();
                $this->view->redirectPage();
            } else {
                $this->view->renderPage();
                $this->model->unsetNotification();
            }
        } else {
            $this->view = new View\LoginLoginView($this->model);
            $willRedirect = false;
            if ($this->view->wasLoginButtonClicked()) {
                if ($this->model->tryLogin($this->view->getUsername(), $this->view->getPassword(), $this->view->wasAutoLoginChecked())) {
                    $this->view->setCookiesIfAutoLogin();
                    $this->view->setServersideCookieExpiration();
                    $willRedirect = true;
                }
            } elseif ($this->view->doesLoginCookieExist()) {
                if ($this->model->tryLoginWithCookie($this->view->getUsernameFromCookie(), $this->view->getEncryptedPasswordFromCookie())) {
                    $willRedirect = true;
                } else {
                    $this->view->clearCookies();
                }
            }
            if ($willRedirect && $this->model->isLoggedIn()) {
                $this->view->redirectPage();
            } else {
                $this->view->renderPage();
                $this->model->unsetNotification();
            }
        }
    }
}