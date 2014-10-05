<?php

require_once("DAO.php");

class RegisterModel {
	private $dao;
	private $savedCredentials;
	
	public function __construct() {
		$this->dao = new DAO();
		$this->savedCredentials = $this->dao->getUsers();
	}
	
	//Validerar användaruppgifter. Returnerar valideringsmeddelande, samt true om valideringen går igenom, annars false
	public function tryRegister($userName, $password, $repeatedPassword) {
		$userNameLength = mb_strlen($userName, "utf8");
		$passwordLength = mb_strlen($password, "utf8");
		$repPasswordLength = mb_strlen($repeatedPassword, "utf8");
		
		if ($userNameLength < 3 && $passwordLength < 6 && $repPasswordLength < 6){
			$string = "<p>Användarnamnet har för få tecken. Minst 3 tecken</p><p>Lösenorden har för få tecken. Minst 6 tecken</p>";
		}elseif ($userNameLength >= 3 && $passwordLength < 6 || $userNameLength >= 3  && $repPasswordLength < 6){
			$string = "Lösenorden har för få tecken. Minst 6 tecken";
		}elseif($userNameLength < 3 && $passwordLength >= 6 || $userNameLength < 3 && $repPasswordLength >= 6){
			$string = "Användarnamnet har för få tecken. Minst 3 tecken";
		}elseif(strcmp($password, $repeatedPassword) !== 0){
			$string = "Lösenorden matchar inte";
		}elseif (array_key_exists($userName, $this->savedCredentials)) {
			$string = "Användarnamnet är redan upptaget";
			//(http://stackoverflow.com/questions/878715/checking-string-for-illegal-characters-using-regular-expression)
		}elseif (preg_match("/[\W]/i", $userName)){
			$string = "Användarnamnet innehåller ogiltiga tecken";
		}else{
			//Skriver användaruppgifter till textfil och sparar användarnamn i sessionsvariabel
			$this->dao->saveUser($userName, $password);
			$_SESSION["LoginModel::Username"] = $userName;
			//Denna sträng används egentligen inte men returneras av metoden ändå
			$string = "Registrering av ny användare lyckades";
			return array($string, true);
		}
		return array($string, false);
	}
}
