<?php

class Traitement {

    private $identifiant;
    private $idMaladie;
    private $matriculeMedecin;
    private $matriculePatient;
    private $recommendations;

    function __construct($identifiant, $idMaladie, $matriculeMedecin, $matriculePatient, $recommendations) {
        $this->identifiant = $identifiant;
        $this->idMaladie = $idMaladie;
        $this->matriculeMedecin = $matriculeMedecin;
        $this->matriculePatient = $matriculePatient;
        $this->recommendations = $recommendations;
    }

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function getIdMaladie() {
        return $this->idMaladie;
    }

    public function getMatriculeMedecin() {
        return $this->matriculeMedecin;
    }

    public function getMatriculePatient() {
        return $this->matriculePatient;
    }

    public function getRecommendations() {
        return $this->recommendations;
    }

}

?>
