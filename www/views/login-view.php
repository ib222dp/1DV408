<?php

namespace LoginApp\View;

use LoginApp\Model\LoginModel;

require_once("html-templates/head-html.php");
require_once("html-templates/footer-html.php");


abstract class LoginView {

    protected $model;
    protected $headHtml;
    protected $footerHtml;

    protected $username;
    protected $password;
    protected $autoLogin;

    public function __construct(LoginModel $model) {
        $this->model = $model;
        $this->footerHtml = new FooterHtml();
    }

}