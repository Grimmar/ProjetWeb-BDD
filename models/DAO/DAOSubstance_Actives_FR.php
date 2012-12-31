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
require_once(ROOT."models/Entite/Substance_Actives_FREntity.php");

class DAOSubstance_Actives_FR extends AbstractDAO {

    function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Substances_Actives_FR WHERE identifiant = :identifiant");
        $count = $req->execute(array("identifiant" => $id));
        return $count;
    }

    public function find($a) {
       $sqlrequest = "SELECT * FROM Substances_Actives_FR";
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
            array_push($result, new Substance_Actives_FREntity($data->IDENTIFIANT, $data->LIBELLE, $data->CLASSES));
        }
        return $result;
    }

    public function get($id) {
         $req = $this->bdd->prepare('SELECT * FROM Substances_Actives_FR WHERE identifiant = :identifiant');
        $req->execute(array("code" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            return null;
        } else {
            return new Substance_Actives_FREntity($donnee[0]->IDENTIFIANT, $donnee[0]->LIBELLE, $donnee[0]->CLASSES);
        }
    }

    public function insert($entity) {
        var_dump($entity);
        $req = $this->bdd->prepare('INSERT INTO Substances_Actives_FR (identifiant, libelle, classes) VALUES 
			(:identifiant, :libelle, classe_t(:classeId, :classeLib, :classeIdP))');
        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'classeId' => $entity->getClasses()->getIdentifiant(),
            'classeLib' => $entity->getClasses()->getLibelle(),
            'classeIdP' => $entity->getClasses()->getIdPere()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Substances_Actives_FR s SET libelle = :libelle, s.Classe_t.identifiant = :classe_id, s.Classe_t.libelle = :classe_lib,
            s.Classe_t.idPere = :classe_idP, WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'classeId' => $entity->getClasses()->getIdentifiant(),
            'classeLib' => $entity->getClasses()->getLibelle(),
            'classeIdP' => $entity->getClasses()->getIdPere()
        ));
        return $count;
    }

}

?>
