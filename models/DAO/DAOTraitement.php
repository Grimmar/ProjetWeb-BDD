<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOTraitement
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/Traitement.php");
require_once("DAOConsultation.php");

class DAOTraitement extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Traitement WHERE identifiant = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Traitements WHERE :where');
        $where = getWhereArray($a);
        $donnee = $req->execute(array("where" => $where));
        $daoConsult = new DAOConsultation();
        $result = array();
        while ($ligne = $donnee->fetch(PDO::FETCH_OBJ)) {
            $traitement = new Traitement($ligne->identifiant, $daoConsult->get($ligne->idConsultation), $ligne->duree);
            array_push($result, $traitement);
        }


        /* $daoConsult = new DAOConsultation();       
          $consult =  $daoConsult->get($donnee); */
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Traitements WHERE identifiant = :id');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $daoConsult = new DAOConsultation();
            $traitement = new Traitement($donnee['identifiant'], $daoConsult->get($donnee['idConsultation']), $donnee['duree']);
            return $traitement;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Traitements (identifiant, idConsultation, duree) VALUES
			(:identifiant, :idConsultation, :duree');

        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'idConsultation' => $entity->getIdConsultation(),
            'duree' => $entity->getDuree()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Traitements t SET idConsultation = :idConsultation, duree = :duree WHERE identifiant = :identifiant');
        $count =  $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'idConsultation' => $entity->getIdConsultation(),
            'duree' => $entity->getDuree()
        ));
        return $count;
    }

}

?>
