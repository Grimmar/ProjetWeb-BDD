<?php

/**
 * Description of DAOClasse_Pharmacologique
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/ClassePharmacologiquesEntity.php");

class ClassePharmacologiqueDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Classes_Pharmacologiques ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Classes_Pharmacologiques
            WHERE identifiant = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Classes_Pharmacologiques ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new ClassePharmacologiqueEntity($d->identidiant,
                            $d->libelle, $d->idpere));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Classes_Pharmacologiques
            WHERE identifiant = :id');
        $statement->execute(array("id" => $id));
        $d = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            return null;
        }
        return new ClassePharmacologiqueEntity($d[0]->identidiant,
                        $d[0]->libelle, $d[0]->idpere);
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Classes_Pharmacologiques 
            (identifiant, libelle, idPere) VALUES (:id, 
            :libelle, :idPere)');
        $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Classes_Pharmacologiques 
            SET libelle = :libelle, idPere = :idPere 
            WHERE identifiant = :id');
        $count = $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()));
        return $count;
    }

}

?>
