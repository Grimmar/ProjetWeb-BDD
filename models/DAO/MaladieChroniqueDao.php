<?php

/**
 * Description of DAOMaladie_Chronique
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/MaladieChroniqueEntity.php");

class MaladieChroniqueDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Maladies_Chroniques ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Maladies_Chroniques 
            WHERE code = :code");
        $count = $statement->execute(array("code" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Maladies_Chroniques ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new MaladieChroniqueEntity($d->code, $d->libelle));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Maladies_Chroniques 
            WHERE code = :code');
        $statement->execute(array("code" => $id));
        $d = $statement->FetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            return null;
        }
        return new MaladieChroniqueEntity($d[0]->code, $d[0]->libelle);
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Maladies_Chroniques (code,
            libelle) VALUES (:code, :libelle)');
        $statement->execute(array(
            'code' => $entity->getCode(),
            'libelle' => $entity->getLibelle()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Maladies_Chroniques 
            SET libelle = :libelle  WHERE code = :code');
        $count = $statement->execute(array(
            'code' => $entity->getCode(),
            'libelle' => $entity->getLibelle()));
        return $count;
    }

    public function getMaladiesChroniquesOfPatient($mat) {
        if ($mat == null) {
            return null;
        }

        $sql = "SELECT * FROM Maladies_Chroniques 
            JOIN Patients_MaladieChronique ON matricule = :mat";

        $statement = $this->bdd->prepare($sql);
        $statement->bindValue(":mat", $mat);
        $statement->execute();
        $d = $statement->fetchAll(PDO::FETCH_OBJ);
        $r = array();
        foreach ($statement as $d) {
            $caracteristique = new MaladieChroniqueEntity($d->code,
                            $d->libelle);

            array_push($r, $caracteristique);
            unset($caracteristique);
        }
        return $r;
    }

}

?>
