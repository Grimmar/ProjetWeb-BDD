<?php

require_once("PersonneEntity.php");

class PatientEntity extends PersonneEntity {

    public function __construct($matricule, $nom, $prenom, $telephone, $numeroSecu, $dateNaissance, $adresse) {
        parent::__construct($matricule, $nom, $prenom, $telephone, $numeroSecu, $dateNaissance, $adresse);
    }

}

?>
