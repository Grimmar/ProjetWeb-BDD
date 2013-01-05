<?php

class TraitementEntity {

    private $identifiant;
    private $idConsultation;
    private $duree;

    function __construct($identifiant, $idConsultation, $duree) {
        $this->identifiant = $identifiant;
        $this->idConsultation = $idConsultation;
        $this->duree = $duree;
    }

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function getIdConsultation() {
        return $this->idConsultation;
    }

    public function getDuree() {
        return $this->duree;
    }

}

?>
