<?php

require_once("html-templates/head-html.php");
require_once("html-templates/footer-html.php");

class RegisterUserView {
	private $model;
	private $headHtml;
	private $footerHtml;
	private $topPage;
	private $bottomPage;
	
	public function __construct(RegisterModel $model) {	
		$this->model = $model;
		$this->headHtml = new HeadHtml('1DV408 - Register');
		$this->footerHtml = new FooterHtml();
		
		$this->topPage .=	$this->headHtml->getHtml() .
							'<h1>Laborationskod hl222ih/ib222dp</h1>
							<p><a href="?login" onclick="">Tillbaka</a></p>
							<h2>Ej Inloggad, Registrerar användare</h2>
							<form action="index.php?' . http_build_query($_GET) . '" method="post">
							<fieldset>
							<legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>';
		
		$this->bottomPage .=	'<label>Namn:</label>
								<input type="text" name="userName" value="' . filter_var(trim($_POST['userName']), FILTER_SANITIZE_STRING) . '" />
								<label>Lösenord:</label>
								<input type="password" name="password" />
								<label>Repetera lösenord:</label>
								<input type="password" name="repPassword" />
								<label>Skicka:</label>
								<input type="submit" name="registerButton" value="Registrera" />
								</fieldset>
								</form>'
								. $this->footerHtml->getHtml();
	}
	
	//Kontrollerar om användaren klickat på "Registrera"
	public function wasRegisterButtonClicked() {
		if(isset($_POST["registerButton"])){
			return true;
		}else{
			return false;
		}
	}
	//Hämtar användarnamn
	public function getUsername() {
		if(isset($_POST["userName"])){
			$userName = $_POST["userName"];
			return $userName;
		}else{
			exit();
		}
	}
	//Hämtar lösenord
	public function getPassword(){
		if(isset($_POST["password"])){
			$password = filter_var(trim($_POST["password"]), FILTER_SANITIZE_STRING);
			return $password;
		}else{
			exit();
		}
	}
	//Hämtar repeterat lösenord
	public function getRepeatedPassword() {
		if(isset($_POST["repPassword"])){
			$repPassword = filter_var(trim($_POST["repPassword"]), FILTER_SANITIZE_STRING);
			return $repPassword;
		}else{
			exit();
		}
	}
	//Visar registreringsformulär utan valideringsmeddelande
	public function renderPage() {
		echo $this->topPage . $this->bottomPage;
	}
	//Visar registreringsformulär med valideringsmeddelande
	public function renderValidationPage($string) {
		echo $this->topPage . '<p>' . $string	. '</p>' . $this->bottomPage;
	}
}
