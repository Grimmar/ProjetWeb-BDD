<?php

class MedicamentEntity {

    private $codeCIS;
    private $libelleMedicament;

    public function __constrcut($cCIS, $lib) {
        $this->codeCIS = $cCIS;
        $this->libelleMedicament = $lib;
    }

    public function getCodeCIS() {
        return $this->codeCIS;
    }

    public function getLibelleMedicament() {
        return $this->libelleMedicament;
    }

}

?>
