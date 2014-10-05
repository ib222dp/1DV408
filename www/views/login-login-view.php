<?php

require_once("login-view.php");

class LoginLoginView extends LoginView {
	private $postUsernameKey;
	private $postPasswordKey;
	private $postAutoLoginCheckedKey;
	private $postLoginButtonNameKey;
	private $bottomPage;

	public function __construct(LoginModel $model) {
		$this->postUsernameKey = get_class() . '::Username';
		$this->postPasswordKey = get_class() . '::Password';
		$this->postAutoLoginCheckedKey = get_class() . '::AutoLoginChecked';
		$this->postLoginButtonNameKey = get_class() . '::LoginButtonName';

		$this->username = (isset($_POST[$this->postUsernameKey]) ? $_POST[$this->postUsernameKey] : "");
		$this->password = (isset($_POST[$this->postPasswordKey]) ? $_POST[$this->postPasswordKey] : "");
		$this->autoLogin = (isset($_POST[$this->postAutoLoginCheckedKey]) ? true : false);

		parent::__construct($model);

		$this->headHtml = new HeadHtml('1DV408 - Login');
		
		$this->bottomPage .=	'<label for="usernameId">Användarnamn:</label>
								<input type="text" name="' . $this->postUsernameKey . '"
								id="usernameId" value="' . $this->model->getUserName() . '" autofocus />
								<label for="passwordId">Lösenord:</label>
								<input type="password" name="' . $this->postPasswordKey . '" id="passwordId" />
								<label for="autoLoginId">Håll mig inloggad:</label>
								<input type="checkbox" name="' . $this->postAutoLoginCheckedKey . '" id="autoLoginId"' .
								($this->autoLogin ? "checked" : "") . ' />
								<input type="submit" name="' . $this->postLoginButtonNameKey . '" value="Logga in" />
								</fieldset>
								</form>'
								. $this->footerHtml->getHtml();
	}

	public function wasLoginButtonClicked() {
		return isset($_POST[$this->postLoginButtonNameKey]);
	}
	//Kontrollerar om ny användare har registrerats genom att kontrollera om "register" finns som URL-parameter
	public function wasNewUserRegistered(){
		if(array_key_exists("register", $_GET)){
			return true;
		}else{
			return false;
		}
	}

	public function getUsername() {
		return $this->username;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function wasAutoLoginChecked() {
		return $this->autoLogin;
	}
	
	public function doesLoginCookieExist() {
		return ((isset($_COOKIE[$this->cookieUsernameKey]) || (isset($_COOKIE[$this->cookieEncryptedPasswordKey]))));
	}
	
	public function renderPage() {
		echo				$this->headHtml->getHtml() .
							'<h1>Laborationskod hl222ih/ib222dp</h1>
							<p><a href="?register" onclick="">Registrera ny användare</a></p>
							<h2>Ej Inloggad</h2>
							<form action="' . $_SERVER['PHP_SELF'] . '" method="post">
							<fieldset>
							<legend>Login - Skriv in användarnamn och lösenord</legend>'
							. ($this->model->getNotification() ? '<p>' . $this->model->getNotification() . '</p>' : '') 
							. $this->bottomPage;
	}
	//Visar login-formulär om ny användare har registrerats
	public function renderLoginPage() {
		echo				$this->headHtml->getHtml() .
							'<h1>Laborationskod hl222ih/ib222dp</h1>
							<p><a href="?login" onclick="">Tillbaka</a></p>
							<h2>Ej Inloggad</h2>
							<form action="' . $_SERVER['PHP_SELF'] . '" method="post">
							<fieldset>
							<legend>Login - Skriv in användarnamn och lösenord</legend>
							<p>Registrering av ny användare lyckades</p>' 
							. $this->bottomPage;
	}
	
	public function setCookiesIfAutoLogin() {
		if ($this->autoLogin) {
			$encryptedPassword = $this->model->encryptPassword($_POST[$this->postPasswordKey]);
			setcookie($this->cookieUsernameKey, $_POST[$this->postUsernameKey], time()+300, '/'); //expire in 30 days(changed to 5 min for testing)
			setcookie($this->cookieEncryptedPasswordKey, $encryptedPassword, time()+300, '/');
		}
	}
}
