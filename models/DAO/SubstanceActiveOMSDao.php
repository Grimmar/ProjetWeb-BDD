<?php

/**
 * Description of DAOSubstance_Actives_OMS
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/SubstanceActiveOMSEntity.php");

class SubstanceActiveOMSDao extends SubstanceActiveDao {

    public function createOppositeSubstance($id, $lib, $cl, $co) {
        return new SubstanceActivesFREntity($id, $lib, $cl, $co);
    }

    public function createSubstance($id, $lib, $cl, $co) {
        return new SubstanceActivesOMSEntity($id, $lib, $cl, $co);
    }

    public function getTable() {
        return "Substances_Actives_OMS";
    }

    public function insertCorrespondance($entity) {
       
    }

}

?>
