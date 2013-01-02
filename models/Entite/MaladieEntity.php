<?php

class MaladieEntity {

    private $idMaladie;
    private $codeArborescence;
    private $idPere;
    private $libelle;

    public function __construct($idMaladie, $codeArborescence, $idPere,
            $libelle) {
        $this->idMaladie = $idMaladie;
        $this->codeArborescence = $codeArborescence;
        $this->idPere = $idPere;
        $this->libelle = $libelle;
    }

    public function getIdMaladie() {
        return $this->idMaladie;
    }

    public function getCodeArborescence() {
        return $this->codeArborescence;
    }

    public function getIdPere() {
        return $this->idPere;
    }

    public function getLibelle() {
        return $this->libelle;
    }

}

?>
