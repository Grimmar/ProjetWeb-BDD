<?php

require_once("EffetIndesirableEntity.php");

class EffetIndesirableOMSEntity extends EffetIndesirableType {

    function __construct($identifiant, $libelle, $idPere) {
        parent::__construct($identifiant, $libelle, $idPere);
    }

}

?>
