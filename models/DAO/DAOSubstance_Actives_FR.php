<?php

/**
 * Description of DAOSubstance_Active_FR
 *
 * @author david
 */
require_once ("AbstractDAO.php");
require_once(ROOT . "models/Entite/Substance_Actives_FREntity.php");

class DAOSubstance_Actives_FR extends AbstractDAO {

    function count() {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Substances_Actives_FR WHERE identifiant = :identifiant");
        $count = $req->execute(array("identifiant" => $id));
        return $count;
    }

     public function find($a) {
       $sqlrequest = "SELECT identifiant, libelle, s.classes.classe.identifiant FROM Substances_Actives_FR s";
       //s.classes.identifiant, s.classes.libelle, s.CLASSES.IDPERE 
        if ($a != null) {
            if (is_array($a)) {
                $sqlrequest .= $this->getWhereArray($a);
            } else {
                return null;
            }
        }
        $req = $this->bdd->prepare($sqlrequest);
        $req->execute();
        var_dump($req);
        $req->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($req as $data) {
            array_push($result, new Substance_Actives_FREntity($data->IDENTIFIANT, $data->LIBELLE, $data->CLASSES));
        }
        return $result;
   }

    public function get($id) {
        //$req = $this->bdd->prepare('SELECT * FROM Substances_Actives_FR 
        //WHERE identifiant = :identifiant');
        $req = $this->bdd->prepare('SELECT s.* FROM the (Select classes 
            from Substances_Actives_FR where identifiant = :identifiant) s');
        $req->execute(array("identifiant" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        $classes = array();
        if (count($donnee) != 1) {
            return null;
        } else {
            foreach ($donnee as $data)
                array_push($classes, new ClasseEntity($data->IDENTIFIANT,
                        $data->LIBELLE, $data->IDPERE));
        }

        $req = $this->bdd->prepare('SELECT identifiant, libelle 
            FROM Substances_Actives_FR where identifiant = :identifiant');
        $req->execute(array("identifiant" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            return null;
        } else {
            return new Substance_Actives_FREntity($donnee[0]->IDENTIFIANT,
                    $donnee[0]->LIBELLE, $classes);
        }
    }

    public function insert($entity) {
        var_dump($entity);
        $req = $this->bdd->prepare('INSERT INTO Substances_Actives_FR (
            identifiant, libelle, classes) VALUES (:identifiant, :libelle,
            classe_t(classe(:classeId, :classeLib, :classeIdp)))');
        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'classeId' => $entity->getClasses()->getIdentifiant(),
            'classeLib' => $entity->getClasses()->getLibelle(),
            'classeIdP' => $entity->getClasses()->getIdPere()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Substances_Actives_FR s SET 
            libelle = :libelle, s.Classe_t.identifiant = :classe_id, 
            s.Classe_t.libelle = :classe_lib, s.Classe_t.idPere = :classe_idP,
            WHERE identifiant = :identifiant');
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
