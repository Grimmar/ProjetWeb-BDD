<?php

interface DAO{
	
	//Initialise une connexion a la base de donn�es
	public function getConnexion();
	
	//authentification
	public function getAuthentification($login, $pass);
	
}
?>
