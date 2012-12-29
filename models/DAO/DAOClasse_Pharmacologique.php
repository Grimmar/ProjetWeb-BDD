<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOClasse_Pharmacologique
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/Classe_PharmacologiquesEntity.php");

class DAOClasse_Pharmacologique extends AbstractDAO {

    public function count($entity) {
     
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Classes_Pharmacologiques WHERE identifiant = :identifiant");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Classes_Pharmacologiques WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Classe_PharmacologiqueEntity", array('identifiant', 'libelle', 'idPere'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Classes_Pharmacologiques WHERE identifiant = :identifiant');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $cpharma = new Classe_Pharmacologiques($donnee['identifiant'], $donnee['libelle'], $donnee['idPere']);
            return $cpharma;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Classes_Pharmacologiques (identifiant, libelle, idPere) VALUES 
			(:identifiant, :libelle, :idPere');
        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Classes_Pharmacologiques SET libelle = :libelle, idPere = :idPere  WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()
                ));
        return $count;
    }

}

?>
