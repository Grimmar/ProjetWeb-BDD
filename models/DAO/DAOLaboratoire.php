<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOLaboratoire
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/LaboratoireEntity.php");

class DAOLaboratoire extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Laboratoires WHERE identifiant = :identifiant");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Laboratoires WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "LaboratoireEntity", array('identifiant', 'nom'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Laboratoires WHERE identifiant = :identifiant');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $lab = new Laboratoire($donnee['identifiant'], $donnee['nom']);
            return $lab;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Laboratoires (identifiant, nom) VALUES 
			(:identifiant, :nom');
        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'nom' => $entity->getNom()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Laboratoires SET nom = :nom  WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'nom' => $entity->getNom()
                ));
        return $count;
    }

}

?>
