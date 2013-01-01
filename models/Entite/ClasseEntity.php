<?php

class ClasseEntity{
	
	private $identifiant;
	private $libelle;
	private $idPere;
	
	public function __construct($id, $lib, $idP){
		$this->identifiant = $id;
		$this->libelle = $lib;
		$this->idPere = $idP;
	}
	
	public function getIdentifiant(){
		return $this->identifiant;
	}
	
	public function getLibelle(){
		return $this->libelle;
	}
	
	public function getIdPere(){
		return $this->idPere;
	}
}

?>
