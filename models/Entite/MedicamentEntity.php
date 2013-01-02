<?php

class MedicamentEntity {

    private $codeCIS;
    private $libelle;

    public function __construct($c, $l) {
        $this->codeCIS = $c;
        $this->libelle = $l;
    }

    public function getCodeCIS() {
        return $this->codeCIS;
    }

    public function getLibelle() {
        return $this->libelle;
    }

}

?>
