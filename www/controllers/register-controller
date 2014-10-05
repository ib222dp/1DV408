<?php

require_once("models/register-model.php");
require_once("views/register-user-view.php");
require_once("controllers/login-controller.php");

class RegisterController {
	private $view;
	private $model;

	public function __construct() {
		$this->model = new RegisterModel();
		$this->view = new RegisterUserView($this->model);
	}

	public function start() {
		//Anropar metod som validerar och registrerar användaruppgifter om användaren klickat på "Registrera"-knappen
		if ($this->view->wasRegisterButtonClicked()) {
			$userWasRegistered = $this->model->tryRegister($this->view->getUsername(), $this->view->getPassword(), 
			$this->view->getRepeatedPassword());
			$valMessage = $userWasRegistered[0];
			
			//Visar login-formulär om registreringen lyckades, visar annars valideringsmeddelande
			if ($userWasRegistered[1]) {
				$loginController = new LoginController();
				$loginController->start();
			}else{
				$this->view->renderValidationPage($valMessage);
			}
		//Visar registreringsformulär om användaren inte klickat på "Registrera"-knappen	
		}else{
			$this->view->renderPage();
		}
	}
}
