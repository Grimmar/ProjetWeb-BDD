<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Classe_Chimique
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT . "models/Entite/Classe_ChimiquesEntity.php");

class DAOClasse_Chimique extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Classes_Chimiques WHERE identifiant = :identifiant");
        $count = $req->execute(array("identifiant" => $id));
        return $count;
    }

    public function find($a) {
        $sqlrequest = "SELECT * FROM Classes_Chimiques ";
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
        foreach ($req as $data){
            array_push($result, new Classe_ChimiquesEntity($data->IDENTIFIANT,$data->LIBELLE, $data->IDPERE));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Classes_Chimiques WHERE identifiant = :identifiant');
        $req->execute(array("identifiant" => $id));
         $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            return null;
        } else {
            return new Classe_ChimiquesEntity($donnee[0]->IDENTIFIANT, $donnee[0]->LIBELLE, $donnee[0]->IDPERE);
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Classes_Chimiques (identifiant, libelle, idPere) VALUES 
			(:identifiant, :libelle, :idPere)');
        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Classes_Chimiques SET libelle = :libelle, idPere = :idPere  WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()
                ));
        return $count;
    }

}

?>
