<?php

ini_set("session.cookie_httponly", true); //prevent javascript to access session cookie
ini_set('error_reporting', 0); //prevent error reporting on server code

session_start();

require_once("controllers/login-controller.php");
require_once("controllers/register-controller.php");

setlocale(LC_ALL, "sv_SE");

//Anropar RegisterControllers start-metod om "register" finns som URL-parameter, anropar annars LoginControllers start-metod
if(array_key_exists("register", $_GET)){
	$registerCtrl = new RegisterController();
	$registerCtrl->start();
}else{
	$loginCtrl = new LoginController();
	$loginCtrl->start();
}
