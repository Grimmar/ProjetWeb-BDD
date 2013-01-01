<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOSymptome
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/SymptomeEntity.php");

class DAOSymptome extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Symptomes WHERE code = :code");
        $count = $req->execute(array("code" => $id));
        return $count;
    }

    public function find($a) {
        $sqlrequest = "SELECT * FROM Symptomes ";
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
            array_push($result, new SymptomeEntity($data->CODE, $data->LIBELLE));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Symptomes WHERE code = :id');
        $req->execute(array(":id" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
               echo "ici !";
            return null;
        } else {
            return new SymptomeEntity($donnee[0]->CODE, $donnee[0]->LIBELLE);
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Symptomes (code, libelle) VALUES 
			(:code, :libelle)');
        $req->execute(array(
            'code' => $entity->getCode(),
            'libelle' => $entity->getLibelle()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Symptomes SET libelle = :libelle  WHERE code = :code');
        $count = $req->execute(array(
            'code' => $entity->getCode(),
            'libelle' => $entity->getLibelle()
                ));
        return $count;
    }

}

?>
