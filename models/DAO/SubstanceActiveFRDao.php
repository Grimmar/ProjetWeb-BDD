<?php

/**
 * Description of DAOSubstance_Active_FR
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/SubstanceActiveFREntity.php");

class SubstanceActiveFRDao extends SubstanceActiveDao {

    public function createOppositeSubstance($id, $lib, $cl, $co) {
        return new SubstanceActivesOMSEntity($id, $lib, $cl, $co);
    }

    public function createSubstance($id, $lib, $cl, $co) {
        return new SubstanceActivesFREntity($id, $lib, $cl, $co);
    }

    public function getTable() {
        return "Substances_Actives_FR";
    }

    public function insertCorrespondance($entity) {
        
    }

}

?>
