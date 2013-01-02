<?php

/**
 * Description of DAOMaladie
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/MaladieEntity.php");

class MaladieDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT * FROM Maladies ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement::rowCount();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Maladies 
            WHERE idMaladie = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Maladies ";
        if ($a != null && is_array($a)) {
            $sql .=$this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new MaladieEntity($d->idmaladie,
                            $d->codearborescence, $d->idpere, $d->libelle));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Maladies 
            WHERE idMaladie = :id');
        $statement->execute(array("id" => $id));
        $d = $statement->fetchAll(PDO::FETCH_OBJ);
        if ($statement::rowCount() != 1) {
            return null;
        }
        return new MaladieEntity($d->idmaladie,
                        $d->codearborescence, $d->idpere, $d->libelle);
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Maladies (idMaladie,
            codeArborescence, idPere, libelle) values
			(:id, :codeArborescence, :idPere, :libelle)');

        $statement->execute(array(
            'id' => $entity->getIdMaladie(),
            'codeArborescence' => $entity->getCodeArborescence(),
            'idPere' => $entity->getIdPere(),
            'libelle' => $entity->getLibelle()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Maladies SET 
            codeArborescence = :codeArborescence, idPere = :idPere,
            libelle = :libelle WHERE idMaladie = :id');
        $count = $statement->execute(array(
            'id' => $entity->getIdMaladie(),
            'codeArborescence' => $entity->getCodeArborescence(),
            'idPere' => $entity->getIdPere(),
            'libelle' => $entity->getLibelle()));
        return $count;
    }

}

?>
