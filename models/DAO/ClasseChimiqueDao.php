<?php

/**
 * Description of Classe_Chimique
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/ClasseChimiquesEntity.php");

class ClasseChimiqueDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Classes_Chimiques ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Classes_Chimiques 
            WHERE identifiant = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Classes_Chimiques ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new ClasseChimiqueEntity($d->identifiant,
                            $d->libelle, $d->idpere));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Classes_Chimiques 
            WHERE identifiant = :id');
        $statement->execute(array("id" => $id));
        $d = $statement->FetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            return null;
        }
        return new ClasseChimiqueEntity($d->identifiant, $d->libelle,
                        $d->idpere);
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Classes_Chimiques 
            (identifiant, libelle, idPere) VALUES (:id,
            :libelle, :idPere)');
        $req->execute(array(
            'id' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Classes_Chimiques 
            SET libelle = :libelle, idPere = :idPere
            WHERE identifiant = :id');
        $count = $req->execute(array(
            'id' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()));
        return $count;
    }

}

?>
