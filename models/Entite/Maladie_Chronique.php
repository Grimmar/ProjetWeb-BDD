<?php

class Maladie_Chronique {

    private $code;
    private $libelle;

    public function __construct($code, $libelle) {
        $this->code = $code;
        $this->libelle = $libelle;
    }

    public function getCode() {
        return $this->code;
    }

    public function getLibelle() {
        return $this->libelle;
    }

}

?>
