<?php

require_once("Effet_IndesirableEntity.php");

class Effet_Indesirable_OMSEntity extends Effet_IndesirableEntity {

    function __construct($identifiant, $libelle, $idPere) {
        parent::__construct($identifiant, $libelle, $idPere);
    }

}

?>
