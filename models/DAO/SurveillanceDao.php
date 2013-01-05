<?php

/**
 * Description of PatientDao
 *
 * @author david
 */
//TODO Caractéristiques + Maladies chroniques
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/SurveillanceEntity.php");

class SurveillanceDao extends AbstractDao {

    public function __construct() {
        parent::__construct();
    }

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Surveillance ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Surveillance 
            WHERE identifiant = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Surveillance ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            $surveillance = new SurveillanceEntity($d->identifiant, $d->medecin,
                            $d->nombreMedicamentDeveloppe, $d->nombreLabTravaille,
                            $d->nombreMedicamentPrescrit, $d->rapport);
            array_push($result, $surveillance);
            unset($surveillance);
        }
        return $result;
    }

    public function get($id) {
        $sql = "SELECT * FROM Surveillance m 
            WHERE matricule = :id";

        $statement = $this->bdd->prepare($sql);
        $statement->execute(array(":id" => $id));
        $d = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            return null;
        }
        $surveillance = new SurveillanceEntity($d->identifiant, $d->medecin,
                            $d->nombreMedicamentDeveloppe, $d->nombreLabTravaille,
                            $d->nombreMedicamentPrescrit, $d->rapport);
        return $surveillance;
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Surveillance(medecin, nombreMedicamentDeveloppe,
            nombreLabTravaille, nombreMedicamentPrescrit, rapport) VALUES(:m, :nbMD,
            :nbLT, :nbMP, :rap)');

        $statement->execute(array(
            'm' => $entity->getMedecin(),
            'nbMD' => $entity->getNombreMedicamentDeveloppe(),
            'ndLT' => $entity->getNombreLabTravaille(),
            'nbMP' => $entity->getNombreMedicamentPrescrit(),
            'rap' => $entity->getRapport()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Surveillance s SET medecin = :m,
            nombreMedicamentDeveloppe = :nbMD, nombreLabTravaille = :nbLT,
            nombreMedicamentPrescrit = :nbMP,
            rapport = :rap
            WHERE identifiant = :id');

        $count = $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'm' => $entity->getMedecin(),
            'nbMD' => $entity->getNombreMedicamentDeveloppe(),
            'ndLT' => $entity->getNombreLabTravaille(),
            'nbMP' => $entity->getNombreMedicamentPrescrit(),
            'rap' => $entity->getRapport()));
        return $count;
    }

}

?>
