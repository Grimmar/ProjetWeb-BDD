<?php

class Addresse_TypeEntity{
	
	private $numero;
	private $adresse;
	private $ville;
	private $codePostal;
	
	public function __construct($numero, $adresse,$ville, $codePostal){
		$this->numero = $numero;
		$this->adresse = $adresse;
		$this->ville = $ville;
		$this->codePostal = $codePostal;
	}
	
	public function getNumero(){
		return $this->numero;
	}
	
	public function getAdresse(){
		return $this->adresse;
	}
	
	public function getVille(){
		return $this->ville;
	}
	
	public function getCodePostal(){
		return $this->codePostal;
	}
}
?>
