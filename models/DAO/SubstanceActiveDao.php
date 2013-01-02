<?php

/**
 * Description of SubstanceActiveDao
 *
 * @author Quentin
 */
abstract class SubstanceActiveDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM " . getTable() . " ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    abstract function getTable();

    abstract function createSubstance($id, $lib, $cl, $co);

    abstract function createOppositeSubstance($id, $lib, $cl, $co);

    abstract function insertCorrespondance($entity);

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM " . getTable() . " 
            WHERE identifiant = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    private function getClassesFromTable($id, $table, $jointure) {
        $sql = "SELECT * FROM " . $table .
                " JOIN " . $jointure . " ON substance = :id";
        $statement = $this->bdd->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute(array("id", $id));
        $classes = array();
        while ($d = $statement->fetch()) {
            $classe = new ClasseChimiqueEntity($d->identifiant,
                            $d->libelle, $d->idpere);
            array_push($classes, $classe);
        }
        return $classes;
    }

    protected function getClasses($id) {
        $classesChimiques = getClassesFromTable($id, "Classes_Chimiques", "SubsActClasseChimique");
        $classesPharmaco = getClassesFromTable($id, "Classes_Pharmacologiques", "SubsActClassePharmaco");

        return array_merge($classesChimiques, $classesPharmaco);
    }

    protected function getCorrespondance($id, $classes) {
        $sql = "SELECT * FROM Correspondance_Substances 
            JOIN " . getTable() . " ON " . getIdentifiantName() . " = :id";
        $statement = $this->bdd->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute(array("id", $id));
        $correspondances = array();
        while ($d = $statement->fetch()) {
            $correspondance = new createOppositeSubstance($d->identifiant,
                            $d->libelle, $classes, array($id));
            array_push($correspondances, $correspondance);
        }
        return $correspondances;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM " . getTable() . " ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        var_dump($statement);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            $id = $d->identifiant;
            $classes = getClasses($id);
            $correspondance = getCorrespondance($id, $classes);
            array_push($result, createSubstance($id, $d->libelle, $classes, $correspondance));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM ' . getTable() . '
            WHERE identifiant = :id) ');
        $statement->execute(array("id" => $id));
        $donnee = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            return null;
        }
        $classes = getClasses($id);
        $correspondance = getCorrespondance($id);
        return createSubstance($id, $donnee[0]->libelle, $classes, $correspondance);
    }

    public function insert($entity) {
        var_dump($entity);
        $statement = $this->bdd->prepare('INSERT INTO ' . getTable() . ' (
            identifiant, libelle) VALUES (:id, :libelle))');
        $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle()));

        //TODO insertion classes

        insertCorrespondance($entity);
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE ' . getTable() . ' SET 
            libelle = :libelle WHERE identifiant = :id');
        $count = $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle()));
        //TODO update classes
        updateCorrespondance($entity);
        return $count;
    }

}

?>
