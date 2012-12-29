<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOEffet_Indesirable_OMS
 *
 * @author david
 */

require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/Effet_Indesirable_OMSEntity.php");

class DAOEffet_Indesirable_OMS extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Effets_Indesirables_OMS WHERE identifiant = :identifiant");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Effets_Indesirables_OMS WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Effet_Indesirable_OMSEntity", array('identifiant', 'libelle', 'idPere'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Effets_Indesirables_OMS WHERE identifiant = :identifiant');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $effet_ind_OMS = new Effet_Indesirable_OMS($donnee['identifiant'], $donnee['libelle'], $donnee['idPere']);
            return $effet_ind_OMS;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Effets_Indesirables_OMS (identifiant, libelle, idPere) VALUES 
			(:identifiant, :libelle, :idPere');
        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Effets_Indesirables_OMS SET libelle = :libelle, idPere = :idPere  WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()
                ));
        return $count;
    }

}

?>
