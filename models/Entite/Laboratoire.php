<?php

class Laboratoire {

    private $identifiant;
    private $nom;

    public function __construct($identifiant, $nom) {
        $this->identifiant = $identifiant;
        $this->nom = $nom;
    }

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function getNom() {
        return $this->nom;
    }

}

?>
