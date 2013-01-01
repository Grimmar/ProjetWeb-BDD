<?php

/**
 * Description of DAOSubstance_Actives_OMS
 *
 * @author david
 */
require_once ("AbstractDAO.php");
require_once(ROOT . "models/Entite/Substance_Actives_OMSEntity.php");

class DAOSubstance_Actives_OMS extends AbstractDAO {

    function count() {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Substances_Actives_OMS WHERE identifiant = :identifiant");
        $count = $req->execute(array("identifiant" => $id));
        return $count;
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Substances_Actives_OMS WHERE identifiant = :identifiant");
        $count = $req->execute(array("identifiant" => $id));
        return $count;
    }

    public function find($a) {
        $sqlrequest = "SELECT * FROM Substances_Actives_OMS ";
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
            array_push($result, new Substance_Actives_FREntity($data->IDENTIFIANT, $data->LIBELLE, $data->CLASSES));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Substances_Actives_OMS WHERE identifiant = :identifiant');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $sub_oms = new Substance_Actives_OMS($donnee['identifiant'], $donnee['libelle'], $donnee['classes']);
            return $sub_oms;
        }
    }

   public function insert($entity) {
        var_dump($entity);
        $req = $this->bdd->prepare('INSERT INTO Substances_Actives_OMS (identifiant, libelle, classes) VALUES 
			(:identifiant, :libelle, NULL)');
        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'classeId' => $entity->getClasses()->getIdentifiant(),
            'classeLib' => $entity->getClasses()->getLibelle(),
            'classeIdP' => $entity->getClasses()->getIdPere()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Substances_Actives_OMS s SET libelle = :libelle, s.Classe_t.identifiant = :classe_id, s.Classe_t.libelle = :classe_lib,
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
