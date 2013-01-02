<?php

abstract class EffetIndesirableType {

    private $identifiant;
    private $libelle;
    private $idPere;

    public function __construct($identifiant, $libelle, $idPere) {
        $this->identifiant = $identifiant;
        $this->libelle = $libelle;
        $this->idPere = $idPere;
    }

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function getIdPere() {
        return $this->idPere;
    }

}

?>
