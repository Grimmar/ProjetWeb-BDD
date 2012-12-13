<?php

require_once("Personne.php");

class Medecin extends Personne{
	
	private $login;
	private $role;
	
	public function __construct($l, $r, $opt){
		parent::__construct($opt);
		$this->login = $l;
		$this->role = $r;
	}
	
	public function getLogin(){
		return $this->login;
	}
	
	public function getRole(){
		return $this->role;
	}
}

$arr = array('adresse'=>'ouhouhouhouh');
$medecin = new Medecin("tutu","tutu", $arr);

echo $medecin->getAdresse();
?>
