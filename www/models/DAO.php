<?php
	
class DAO {
	private $file;
	
	public function __construct() {
		$this->file = "users.txt";
	}
	
	//Läser in användaruppgifter i textfil till en associativ array och returnerar arrayen
	//(http://stackoverflow.com/questions/9259640/reading-from-a-file-to-associative-array-in-php)
	public function getUsers() {
		$userArray = array();
		foreach(file($this->file) as $line){
			list($key, $value) = explode(",", $line, 2) + array(null, null);
			if($value !== null)
			{
				$userArray[$key] = trim($value);
			}
		}
		return $userArray;
	}
	
	//Sparar registrerade användaruppgifter till textfil
	public function saveUser($userName, $password){
		$fileHandle = fopen($this->file, "a");
		fwrite($fileHandle, $userName . "," . $password . "\n");
		fclose($fileHandle);
	}	
}
