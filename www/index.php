<?php
require_once("views/HomeView.php");

session_start();

//if ($_POST) echo "this was a post";

$homeView = new HomeView();

$homeView->renderPage();

//echo var_dump($_POST);
//phpinfo();