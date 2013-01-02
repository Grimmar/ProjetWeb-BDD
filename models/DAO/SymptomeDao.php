<?php

/**
 * Description of DAOSymptome
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/SymptomeEntity.php");

class SymptomeDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT * FROM Symptomes ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement::rowCount();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Symptomes 
            WHERE code = :code");
        $count = $statement->execute(array("code" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Symptomes ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new SymptomeEntity($d->code, $d->libelle));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Symptomes 
            WHERE code = :id');
        $statement->execute(array(":id" => $id));
        $d = $statement->FetchAll(PDO::FETCH_OBJ);
        if ($statement::rowCount() != 1) {
            return null;
        }
        return new SymptomeEntity($d[0]->code, $d[0]->libelle);
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Symptomes (code, libelle) 
            VALUES (:code, :libelle)');
        $statement->execute(array(
            'code' => $entity->getCode(),
            'libelle' => $entity->getLibelle()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Symptomes SET libelle = :libelle
            WHERE code = :code');
        $count = $statement->execute(array(
            'code' => $entity->getCode(),
            'libelle' => $entity->getLibelle()));
        return $count;
    }

}

?>
