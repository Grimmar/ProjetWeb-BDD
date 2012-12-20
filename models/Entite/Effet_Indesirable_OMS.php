<?php

require_once("Effet_Indesirable.php");

class Effet_Indesirable_OMS extends Effet_Indesirable {

    function __construct($identifiant, $libelle, $idPere) {
        parent::__construct($identifiant, $libelle, $idPere);
    }

}

?>
