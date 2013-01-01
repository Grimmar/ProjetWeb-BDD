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
require_once(ROOT . "models/Entite/TraitementEntity.php");
require_once("DAOConsultation.php");

class DAOTraitement extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Traitements WHERE identifiant = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        $sqlrequest = "SELECT * FROM Traitements ";
        if ($a != null) {
            if (is_array($a)) {
                $sqlrequest .= $this->getWhereArray($a);
            } else {
                return null;
            }
        }
        $req = $this->bdd->prepare($sqlrequest);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($req as $data) {
            array_push($result, new TraitementEntity($data->IDENTIFIANT, $data->IDCONSULTATION, $data->DUREE));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Traitements WHERE identifiant = :id');
        $req->execute(array(":id" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            echo "ici !";
            return null;
        } else {
            return new TraitementEntity($donnee[0]->IDENTIFIANT, $donnee[0]->IDCONSULTATION, $donnee[0]->DUREE);
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Traitements (identifiant, idConsultation, duree) VALUES
			(:identifiant, :idConsultation, :duree)');

        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'idConsultation' => $entity->getIdConsultation(),
            'duree' => $entity->getDuree()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Traitements t SET idConsultation = :idConsultation, duree = :duree WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'idConsultation' => $entity->getIdConsultation(),
            'duree' => $entity->getDuree()
                ));
        return $count;
    }

}

?>
