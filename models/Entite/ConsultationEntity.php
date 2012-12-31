<?php

class ConsultationEntity {

    private $identifiant;
    private $matriculeMedecin;
    private $matriculePatient;
    private $dateConsultation;

    public function __construct($identifiant, $matriculeMedecin, $matriculePatient, $dateConsultation) {
        $this->identifiant = $identifiant;
        $this->matriculeMedecin = $matriculeMedecin;
        $this->matriculePatient = $matriculePatient;
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

    public function getDateConsultation() {
        return $this->dateConsultation;
    }

}

?>
