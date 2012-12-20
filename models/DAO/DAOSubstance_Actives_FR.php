<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOSubstance_Active_FR
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/Substance_Actives_FR.php");

class DAOSubstance_Actives_FR extends AbstractDAO {

    function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Substances_Actives_FR WHERE identifiant = :identifiant");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Substances_Actives_FR WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Substance_Actives_FR", array('identifiant', 'libelle', 'classes'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Substances_Actives_FR WHERE identifiant = :identifiant');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $sub_fr = new Substance_Actives_FR($donnee['identifiant'], $donnee['libelle'], $donnee['classes']);
            return $sub_fr;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Substances_Actives_FR (identifiant, libelle, classes) VALUES 
			(:identifiant, :libelle, :classes');
        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'classes' => $entity->getClasses()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Substances_Actives_FR SET libelle = :libelle, classes = :classes  WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'classes' => $entity->getClasses()
                ));
        return $count;
    }

}

?>
