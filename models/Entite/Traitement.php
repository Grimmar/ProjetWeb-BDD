<?php
class Traitement{
	
	private $identifiant;
	private $idTraitement;
	private $codeCIS;
	
	public function __construct($identifiant, $idTraitement, $codeCIS){
		$this->identifiant = $identifiant;
		$this->idTraitement = $idTraitement;
		$this->codeCIS = $codeCIS;
	}
	
	public function getIdentifiant(){
		return $this->identifiant;
	}
	
	public function getIdTraitement(){
		return $this->idTraitement;
	}
	
	public function getCodeCIS(){
		return $this->codeCIS;
	}
	
}
?>
