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
        echo $this->bdd . 'bdd';
        echo 'ok';
    }

    //AFFECTER_MALADIE_PATIENT
    public function affecterMaladiePatient($matPatient, $matMedecin, $idMaladie) {
        $params = array();
        $params['idPatient'] = $matPatient;
        $params['idMedecin'] = $matMedecin;
        $params['idMaladie'] = $idMaladie;
        $sql = 'BEGIN AFFECTER_MALADIE_PATIENT(:idPatient, :idMedecin, :idMaladie); END;';
        $d = $this->executeProcedure($sql, $params);
        print_r($d);
    }

    //MEDICAMENTS_FROM_MALADIE
    public function getMedicamentsFromMaladie($idMaladie) {
        $params = array();
        $params['idMaladie'] = $idMaladie;
        echo $idMaladie;
        $sql = 'BEGIN :cursor := MEDICAMENTS_FROM_MALADIE(:idMaladie); END;';
        $d = $this->fetchCursor($sql, $params);
        return $d;
    }

    //PRESCRIRE_MEDICAMENT
    public function prescrireMedicament($consultation, $duration, $cis) {
        
    }

    //PRESCRIRE_RECOMMENDATION
    public function prescrireRecommendation($consultation, $duration, $rec) {
        
    }

    //DETERMINER_MEDICAMENT_EI
    public function getEffetsIndesirablesFromMedicaments($codeCis) {
        $params = array();
        $params['cis'] = $codeCis;
        $sql = 'BEGIN :cursor := codeCis DETERMINER_MEDICAMENT_EI(:cis); END;';
        $d = $this->fetchCursor($sql, $params);
        return $d;
    }

    //LISTE_MEDOC_PRESCR_DEVELOPPEUR
    public function getMedicamentsPrescritParDeveloppeur() {
        $sql = 'BEGIN :cursor := codeCis LISTE_MEDOC_PRESCR_DEVELOPPEUR(); END;';
        $d = $this->fetchCursor($sql);
        return $d;
    }

    //LISTE_MEDOC_PRESCR_LAB
    public function getMedicamentsPrescritParDeveloppeurInLab() {
        $sql = 'BEGIN :cursor := codeCis LISTE_MEDOC_PRESCR_LAB(); END;';
        $d = $this->fetchCursor($sql);
        return $d;
    }

    //PROPOSER_TRAITEMENTS
    public function getPossibleTreatment($mat) {
        $params = array();
        $params['mat'] = $mat;
        $sql = 'BEGIN :cursor := codeCis PROPOSER_TRAITEMENTS(:mat); END;';
        $d = $this->fetchCursor($sql, $params);
        return $d;
    }

    //IS_TRAITEMENT_INTERACTION
    public function isInteractionsTraitement($mat, $meds = array()) {
        
    }

    //GET_TRAITEMENTS_COMMUNS
    public function getTraitementsCommuns($maladie1, $maladie2) {
        
    }

    //INSERER_NOUVEL_EI
    public function insererNouvelEI($medicament, $effet) {
        $params = array();
        $params['med'] = $medicament;
        $params['effet'] = $effet;
        $sql = 'BEGIN :cursor := codeCis PROPOSER_TRAITEMENTS(:med, :effet); END;';
        $d = $this->fetchCursor($sql, $params);
        return $d;
    }

    public function executeProcedure($sql, $bind = array()) {
        $data = array();
        $statement = oci_parse($this->bdd, $sql);
        foreach ($bind as $key => &$val) {
            oci_bind_by_name($statement, $key, $val, -1, OCI_ASSOC);
        }
        oci_execute($statement);
        if (($e = oci_error($statement)) != NULL) {
            throw new Exception($e, -1234);
        }
        oci_fetch_all($statement, $data);
        oci_free_statement($statement);
        return $data;
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

}

?>
