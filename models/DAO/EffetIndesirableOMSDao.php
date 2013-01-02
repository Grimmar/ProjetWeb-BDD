<?php

/**
 * Description of DAOEffet_Indesirable_OMS
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/EffetIndesirableOMSEntity.php");

class EffetIndesirableOMSDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Effets_Indesirables_OMS ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Effets_Indesirables_OMS 
            WHERE identifiant = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Effets_Indesirables_OMS ";
        if ($a != null && is_array($a)) {
            $sql .=$this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new EffetIndesirableOMSEntity($d->identifiant,
                            $d->libelle, $d->idpere));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Effets_Indesirables_OMS 
            WHERE identifiant = :id');
        $statement->execute(array("id" => $id));
        $d = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            return null;
        }
        return new EffetIndesirableOMSEntity($d[0]->identifiant,
                        $d[0]->libelle, $d[0]->idpere);
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Effets_Indesirables_OMS 
            (identifiant, libelle, idPere) VALUES (:id, :libelle, :idPere)');
        $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Effets_Indesirables_OMS 
            SET libelle = :libelle, idPere = :idPere  WHERE identifiant = :id');
        $count = $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()));
        return $count;
    }

}

?>
