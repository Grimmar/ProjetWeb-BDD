<?php

require_once("Personne.php");

class Patient extends Personne {

    public function __construct($matricule, $nom, $prenom, $telephone, $numeroSecu, $dateNaissance, $adresse) {
        parent::__construct($matricule, $nom, $prenom, $telephone, $numeroSecu, $dateNaissance, $adresse);
    }

}

?>
