<?php

interface DAO{
	
	//Initialise une connexion a la base de données
	public function getConnexion();
	
	//authentification
	public function getAuthentification($login, $pass);
	
}
?>
