<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOMaladie
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT . "models/Entite/MaladieEntity.php");

class DAOMaladie extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Maladies WHERE idMaladie = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        $sqlrequest = "SELECT * FROM Maladies";
        if ($a != null) {
            if (is_array($a)) {
                $sqlrequest .=" where " . $this->getWhereArray($a);
            } else {
                return null;
            }
        }
        $req = $this->bdd->prepare($sqlrequest);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($req as $data) {
            array_push($result, new MaladieEntity($data->IDMALADIE, $data->CODEARBORESCENCE, $data->IDPERE, $data->LIBELLE));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Maladies WHERE idMaladie = :identifiant');
        $req->execute(array("identifiant" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            return null;
        } else {
            return new MaladieEntity($donnee[0]->IDMALADIE, $donnee[0]->CODEARBORESCENCE, $donnee[0]->IDPERE, $donnee[0]->LIBELLE);
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Maladies (idMaladie, codeArborescence, idPere, libelle) values
			(:idMaladie, :codeArborescence, :idPere, :libelle)');

        $req->execute(array(
            'idMaladie' => $entity->getIdMaladie(),
            'codeArborescence' => $entity->getCodeArborescence(),
            'idPere' => $entity->getIdPere(),
            'idMaladie' => $entity->getIdMaladie(),
            'libelle' => $entity->getLibelle()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Maladies SET codeArborescence = :codeArborescence, idPere = :idPere,
            libelle = :libelle WHERE idMaladie = :idMaladie');
        $count = $req->execute(array(
            'idMaladie' => $entity->getIdMaladie(),
            'codeArborescence' => $entity->getCodeArborescence(),
            'idPere' => $entity->getIdPere(),
            'idMaladie' => $entity->getIdMaladie(),
            'libelle' => $entity->getLibelle()
                ));
        return $count;
    }

}

?>
