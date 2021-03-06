<?php

/**
 * Description of DAOCaracteristique
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/CaracteristiqueEntity.php");

class CaracteristiqueDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Caracteristiques ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Caracteristiques 
            WHERE code = :code");
        $count = $statement->execute(array("code" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Caracteristiques ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new CaracteristiqueEntity($d->code,
                            $d->libelle));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Caracteristiques 
            WHERE code = :code');
        $statement->execute(array("code" => $id));
        $d = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            return null;
        }
        $carac = new CaracteristiqueEntity($d[0]->code, $d[0]->libelle);
        return $carac;
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Caracteristiques 
            (code, libelle) VALUES (:code, :libelle)');
        $req->execute(array(
            'code' => $entity->getCode(),
            'libelle' => $entity->getLibelle()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Caracteristiques 
            SET libelle = :libelle WHERE code = :code');
        $count = $req->execute(array(
            'code' => $entity->getCode(),
            'libelle' => $entity->getLibelle()));
        return $count;
    }

    public function getCaracteristiquesOfPatient($mat) {
        if ($mat == null) {
            return null;
        }

        $sql = "SELECT * FROM Caracteristiques 
            JOIN Patients_Caracteristiques ON matricule = :mat";

        $statement = $this->bdd->prepare($sql);
        $statement->bindValue(":mat", $mat);
        $statement->execute();
        $d = $statement->fetchAll(PDO::FETCH_OBJ);
        $r = array();
        foreach ($statement as $d) {
            $caracteristique = new CaracteristiqueEntity($d->code,
                            $d->libelle);

            array_push($r, $caracteristique);
            unset($caracteristique);
        }
        return $r;
    }
    
}

?>
