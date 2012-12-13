<?php
require_once("../Model/DAOManager.php");

if(isset($_POST['login']) && isset($_POST['password'])){
	$auth = new Authentification($_POST['login'],$_POST['password']);
	$auth->authentification();
} else {
	header('Location: ../Index.php');
}

class Authentification{

	private $login;
	private $pass;
	
	public function __construc($l, $p){
		$this->login = $l;
		$this->pass = $p;
	}

	public function authentification(){
		$dao = DAOManager::getInstance();
		$user = $dao->getAuthentification($this->login, $this->pass);
		if($user == null){
			header('Location: ../Index.php');
		} else {
			session_start();
			$_SESSION['user'] = serialize($user);
			if($user->getRole() == "admin"){
				header('Location: ../Vue/AccueilAdmin.php');
			} else {
				header('Location: ../Vue/AccueilMedecin.php');
			}
		}
	}
	
	public static function isConnected(){
		$user = $_SESSION['user'];
		if($user == null){
			header('Location: ../Index.php');
		}
	}

}

?>
