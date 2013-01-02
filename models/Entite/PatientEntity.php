<?php

require_once("PersonneEntity.php");

class PatientEntity extends PersonneEntity {

    private $caracteristiques;
    private $maladiesChroniques;

    public function __construct($matricule, $nom, $prenom, $telephone, $numeroSecu, $dateNaissance, $adresse, $caracteristique = null, $maladies = null) {
        parent::__construct($matricule, $nom, $prenom, $telephone, $numeroSecu, $dateNaissance, $adresse);
        $this->caracteristiques = $caracteristique;
        $this->maladiesChroniques = $maladies;
    }

    public function getCaracteristiques() {
        return $this->caracteristiques;
    }

    public function getMaladiesChroniques() {
        return $this->maladiesChroniques;
    }

}

?>
