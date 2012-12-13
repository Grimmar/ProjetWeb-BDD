<?php

abstract class Personne{
	
	
	private $matricule;
	private $nom;           
	private $prenom;      
	private $telephone;     
	private $numeroSecu;   
	private $dateNaissance;
	private $adresse;
	
	//opt represente la liste des attributs dans un tableau
	public function __construct($opt){
		if(is_array($opt)){
			foreach($opt as $k => $v){
				$this->$k= $v;
			}
		}
	}
	
	/*public function __call($name, $argument){
		$get = strtolower(substr($name,3,strlen($name)));
		return $this->$get;
	}*/
	
	public function getMatricule(){
		return $this->matricule;
	}
	
	public function getNom(){
		return $this->nom;
	}
	
	public function getPrenom(){
		return $this->prenom;
	}
	
	public function getTelephone(){
		return $this->telephone;
	}
	
	public function getNumeroSecu(){
		return $this->telephone;
	}
	
	public function getDateNaissance(){
		return $this->telephone;
	}
	
	public function getAdresse(){
		return $this->adresse;
	}
}

?>
