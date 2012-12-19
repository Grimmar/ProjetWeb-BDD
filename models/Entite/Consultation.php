<?php

class Consultation {

    private $identifiant;
    private $matriculeMedecin;
    private $matriculePatient;
    private $idMaladie;
    private $dateConsultation;

    public function __construct($identifiant, $matriculeMedecin, $matriculePatient, $idMaladie, $dateConsultation) {
        $this->identifiant = $identifiant;
        $this->matriculeMedecin = $matriculeMedecin;
        $this->matriculePatient = $matriculePatient;
        $this->idMaladie = $idMaladie;
        $this->dateConsultation = $dateConsultation;
    }

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function getMatriculeMedecin() {
        return $this->matriculeMedecin;
    }

    public function getMatriculePatient() {
        return $this->matriculePatient;
    }

    public function getIdMaladie() {
        return $this->idMaladie;
    }

    public function getDateConsultation() {
        return $this->dateConsultation;
    }

}

?>
