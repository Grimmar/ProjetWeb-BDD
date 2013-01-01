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
require_once(ROOT . "models/Entite/LaboratoireEntity.php");

class DAOLaboratoire extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Laboratoires WHERE identifiant = :identifiant");
        $count = $req->execute(array("identifiant" => $id));
        return $count;
    }

    public function find($a) {
        $sqlrequest = "SELECT * FROM Laboratoires ";
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
            array_push($result, new LaboratoireEntity($data->IDENTIFIANT, $data->NOM));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Laboratoires WHERE identifiant = :identifiant');
        $req->execute(array("identifiant" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            return null;
        } else {
            return new LaboratoireEntity($donnee[0]->IDENTIFIANT, $donnee[0]->NOM);
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Laboratoires (identifiant, nom) VALUES 
			(:identifiant, :nom)');
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
