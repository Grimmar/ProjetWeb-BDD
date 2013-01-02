<?php

abstract class SubstanceActiveEntity {

    private $identifiant;
    private $libelle;
    private $classes; //$classes est un tableau de classe
    private $correspondance; //$correspondance est un tableau de substance

    public function __construct($id, $lib, $cl, $co = null) {
        $this->identifiant = $id;
        $this->libelle = $lib;
        $this->classes = $cl;
        $this->correspondance = $co;
    }

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function getClasses() {
        return $this->classes;
    }

    public function getCorrespondance() {
        return $this->correspondance;
    }

}

?>
