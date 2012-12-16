<?php


abstract class Substance{
	private $identifiant;
	private $libelle;
	private $classes;
	
	//$classes correspond a une table imbriquée, donc probablement une tableau d'objet
	public function __construct($id, $lib, $c){
		$this->identifiant = $id;
		$this->libelle = $lib;
		$this->classes = $c;
	}
	
	public function getIdentifiant(){
		return $this->identifiant;
	}
	
	public function getLibelle(){
		return $this->libelle;
	}
	
	public function getClasses(){
		return $this->classes;
	}
	
}
?>
