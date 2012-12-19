<?php

require_once("Personne.php");

class Medecin extends Personne{
	
	private $login;
        private $motDePasse;
	private $role;
	
	function __construct($login, $motDePasse, $role, $matricule, $nom, $prenom, $telephone, $numeroSecu, $dateNaissance, $adresse) {
            parent::__construct($matricule, $nom, $prenom, $telephone, $numeroSecu, $dateNaissance, $adresse);
            $this->login = $login;
            $this->motDePasse = $motDePasse;
            $this->role = $role;
        }

                
	public function getLogin(){
		return $this->login;
	}
	
	public function getRole(){
		return $this->role;
	}
}
?>
