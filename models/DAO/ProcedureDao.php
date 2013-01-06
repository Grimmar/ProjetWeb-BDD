<?php

/**
 * Description of ProcedureDao
 *
 * @author Quentin
 * */
require_once("DAOManager.php");

class ProcedureDao {

    protected $dao;
    protected $bdd;

    public function __construct() {
        $this->dao = DaoManager::getInstance();
        $this->bdd = $this->dao->getOracleConnexion();
    }

    //AFFECTER_MALADIE_PATIENT
    public function affecterMaladiePatient($matPatient, $matMedecin, $idMaladie) {
        $params = array();
        $val = null;
        $params['idPatient'] = $matPatient;
        $params['idMedecin'] = $matMedecin;
        $params['idMaladie'] = $idMaladie;
        $params['return'] = $val;
        $sql = 'BEGIN :return := AFFECTER_MALADIE_PATIENT(:idPatient, :idMedecin, :idMaladie); END;';
        $d = $this->callFunction($sql, $params);
        return $d;
    }

    //MEDICAMENTS_FROM_MALADIE
    public function getMedicamentsFromMaladie($idMaladie) {
        $params = array();
        $params['idMaladie'] = $idMaladie;
        $sql = 'BEGIN :cursor := MEDICAMENTS_FROM_MALADIE(:idMaladie); END;';
        $d = $this->fetchCursor($sql, $params);
        return $d;
    }

    //PRESCRIRE_MEDICAMENT
    public function prescrireMedicament($consultation, $duration, $cis) {
        $params = array();
        $val = null;
        $params['consult'] = $consultation;
        $params['duration'] = $duration;
        $params['cis'] = $cis;
        $params['return'] = $val;
        $sql = 'BEGIN :return := PRESCRIRE_MEDICAMENT(:consult, :duration, :cis); END;';
        $d = $this->callFunction($sql, $params);
        return $d;
    }

    //PRESCRIRE_RECOMMENDATION
    public function prescrireRecommendation($consultation, $duration, $rec) {
        $params = array();
        $val = null;
        $params['consult'] = $consultation;
        $params['duration'] = $duration;
        $params['rec'] = $rec;
        $params['return'] = $val;
        $sql = 'BEGIN :return := PRESCRIRE_RECOMMENDATION(:consult, :duration, :rec); END;';
        $d = $this->callFunction($sql, $params);
        return $d;
    }

    //DETERMINER_MEDICAMENT_EI
    public function getEffetsIndesirablesFromMedicaments($codeCis) {
        $params = array();
        $params['cis'] = $codeCis;
        $sql = 'BEGIN :cursor := DETERMINER_MEDICAMENT_EI(:cis); END;';
        $d = $this->fetchCursor($sql, $params);
        return $d;
    }

    //LISTE_MEDOC_PRESCR_DEVELOPPEUR
    public function getMedicamentsPrescritParDeveloppeur() {
        $sql = 'BEGIN :cursor := LISTE_MEDOC_PRESCR_DEVELOPPEUR(); END;';
        $d = $this->fetchCursor($sql);
        return $d;
    }

    //LISTE_MEDOC_PRESCR_LAB
    public function getMedicamentsPrescritParDeveloppeurInLab() {
        $sql = 'BEGIN :cursor := LISTE_MEDOC_PRESCR_LAB(); END;';
        $d = $this->fetchCursor($sql);
        return $d;
    }

    //PROPOSER_TRAITEMENTS
    public function getPossibleTreatment($mat) {
        $params = array();
        $params['mat'] = $mat;
        $sql = 'BEGIN :cursor := PROPOSER_TRAITEMENTS(:mat); END;';
        $d = $this->fetchCursor($sql, $params);
        return $d;
    }

    //IS_TRAITEMENT_INTERACTION
    public function isInteractionsTraitement($mat, $meds = array()) {
        $params = array();
        $params['mat'] = $mat;
        $sql = 'SELECT IS_TRAITEMENT_INTERACTION(:mat, :array) "val" FROM DUAL';
        $d = $this->fetchFunctionWithArray($sql, $params, $meds);
        return $d;
    }

    //GET_TRAITEMENTS_COMMUNS 
    public function getTraitementsCommuns($maladie1, $maladie2) {
        $params = array();
        $params['mal1'] = $maladie1;
        $params['mal2'] = $maladie2;
        $sql = 'BEGIN :array :=  GET_TRAITEMENTS_COMMUNS(:mal1, :mal2); END;';
        $d = $this->fetchArray($sql, $params);
        return $d;
    }

    //INSERER_NOUVEL_EI
    public function insererNouvelEI($medicament, $effet) {
        $params = array();
        $params['med'] = $medicament;
        $params['effet'] = $effet;
        $sql = 'BEGIN :cursor := INSERER_NOUVEL_EI(:med, :effet); END;';
        $d = $this->fetchCursor($sql, $params);
        return $d;
    }

    public function callFunction($sql, $bind = array()) {
        $statement = oci_parse($this->bdd, $sql);
        foreach ($bind as $key => &$val) {
            oci_bind_by_name($statement, $key, $val, -1, OCI_ASSOC);
        }
        oci_execute($statement);
        if (($e = oci_error($statement)) != NULL) {
            throw new Exception("" . $e, -1234);
        }

        oci_free_statement($statement);
    }

    public function fetchCursor($sql, $bind = array()) {
        $data = array();

        $curs = oci_new_cursor($this->bdd);
        $statement = oci_parse($this->bdd, $sql);

        oci_bind_by_name($statement, "cursor", $curs, -1, OCI_B_CURSOR);
        foreach ($bind as $key => &$val) {
            oci_bind_by_name($statement, $key, $val, -1, OCI_ASSOC);
        }

        oci_execute($statement);

        if (($e = oci_error($statement)) != NULL) {
            throw new Exception($e, -1234);
        }
        oci_execute($curs);

        oci_fetch_all($curs, $data);
        oci_free_statement($statement);
        oci_free_statement($curs);

        return $data;
    }

    public function fetchArray($sql, $bind = array(), $array = array()) {
        $array = oci_new_collection($this->bdd, 'MEDICAMENTS_TRAIT');
        $statement = oci_parse($this->bdd, $sql);
        oci_bind_by_name($statement, ':array', $array, -1, SQLT_NTY);
        foreach ($bind as $key => &$val) {
            oci_bind_by_name($statement, $key, $val, -1, OCI_ASSOC);
        }
        oci_execute($statement);

        if (($e = oci_error($statement)) != NULL) {
            throw new Exception("" . $e, -1234, NULL);
        }
        $tab = array();
        for ($i = 0; $i < $array->size(); $i++) {
            array_push($tab, $array->getElem($i));
        }
        oci_free_statement($statement);

        return $tab;
    }

    public function fetchFunctionWithArray($sql, $bind = array(), $array = array()) {
        $array = oci_new_collection($this->bdd, 'MEDICAMENTS_TRAIT');
        $statement = oci_parse($this->bdd, $sql);
        oci_bind_by_name($statement, ':array', $array, -1, SQLT_NTY);
        foreach ($bind as $key => &$val) {
            oci_bind_by_name($statement, $key, $val, -1, OCI_ASSOC);
        }
        oci_execute($statement);

        if (($e = oci_error($statement)) != NULL) {
            throw new Exception("" . $e, -1234, NULL);
        }
        $tab = array();
        oci_fetch_all($statement, $tab);
        oci_free_statement($statement);

        return $tab;
    }

}

?>