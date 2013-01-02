<?php

/**
 * Description of DAOEffet_Indesirable_FR
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/EffetIndesirableFREntity.php");

class EffetIndesirableFRDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT * FROM Effets_Indesirables_FR ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement::rowCount();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Effets_Indesirables_FR 
            WHERE identifiant = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Effets_Indesirables_FR ";
        if ($a != null && is_array($a)) {
            $sql .=$this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new EffetIndesirableFREntity($d->identifiant,
                            $d->libelle, $d->idpere));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Effets_Indesirables_FR 
            WHERE identifiant = :id');
        $statement->execute(array("id" => $id));
        $d = $statement->FetchAll(PDO::FETCH_OBJ);
        if ($statement::rowCount() != 1) {
            return null;
        }
        return new EffetIndesirableFREntity($d[0]->identifiant,
                        $d[0]->libelle, $d[0]->idpere);
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Effets_Indesirables_FR 
            (identifiant, libelle, idPere) VALUES (:id, :libelle, :idPere)');
        $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Effets_Indesirables_FR 
            SET libelle = :libelle, idPere = :idPere  WHERE identifiant = :id');
        $count = $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()));
        return $count;
    }

}

?>
