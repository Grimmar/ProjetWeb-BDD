<?php

/**
 * Description of DAOTraitement
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/TraitementEntity.php");
require_once("ConsultationDao.php");

class TraitementDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Traitements ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Traitements 
            WHERE identifiant = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Traitements ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new TraitementEntity($d->identifiant,
                            $d->idconsultation, $d->duree));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Traitements 
            WHERE identifiant = :id');
        $statement->execute(array(":id" => $id));
        $d = $statement->FetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            echo "ici !";
            return null;
        }
        return new TraitementEntity($d[0]->identifiant,
                        $d[0]->idconsultation, $d[0]->duree);
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Traitements 
            (identifiant, idConsultation, duree) VALUES (:id, 
            :consult, :duree)');

        $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'consult' => $entity->getIdConsultation(),
            'duree' => $entity->getDuree()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Traitements t 
            SET idConsultation = :consult, duree = :duree 
            WHERE identifiant = :id');
        $count = $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'consult' => $entity->getIdConsultation(),
            'duree' => $entity->getDuree()));
        return $count;
    }

}

?>
