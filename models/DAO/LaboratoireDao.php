<?php

/**
 * Description of DAOLaboratoire
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/LaboratoireEntity.php");

class LaboratoireDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Laboratoires ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Laboratoires 
            WHERE identifiant = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Laboratoires ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new LaboratoireEntity($d->identifiant, $d->nom));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Laboratoires 
            WHERE identifiant = :id');
        $statement->execute(array("id" => $id));
        $d = $statement->FetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            return null;
        }
        return new LaboratoireEntity($d[0]->identifiant, $d[0]->nom);
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Laboratoires (identifiant, nom)
            VALUES (:id, :nom)');
        $req->execute(array(
            'id' => $entity->getIdentifiant(),
            'nom' => $entity->getNom()));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Laboratoires SET nom = :nom 
            WHERE identifiant = :id');
        $count = $req->execute(array(
            'id' => $entity->getIdentifiant(),
            'nom' => $entity->getNom()));
        return $count;
    }

}

?>
