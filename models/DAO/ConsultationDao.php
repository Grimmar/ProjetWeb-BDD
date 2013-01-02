<?php

/**
 * Description of DAOConsultation
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/ConsultationEntity.php");

class ConsultationDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Consultations ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Consultations 
            WHERE identifiant = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Consultations ";
        if ($a != null && is_array($a)) {
            $sql .=$this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $s) {
            array_push($result, new ConsultationEntity($s->identifiant,
                            $s->matriculemedecin, $s->matriculepatient,
                            $s->dateconsutation));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Consultations 
            WHERE identifiant = :id');
        $statement->execute(array(":id" => $id));
        $d = $statement->FetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            return null;
        }
        return new ConsultationEntity($d[0]->identifiant,
                        $d[0]->matriculemedecin, $d[0]->matriculepatient, $d[0]->dateconsutation);
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Consultations (
             matriculeMedecin, matriculePatient, dateConsultation) VALUES(:id,
             :medecin, :patient, to_date(:dateConsultation, \'DD/MM/YYYY\'))');

        $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'medecin' => $entity->getMatriculeMedecin(),
            'patient' => $entity->getMatriculePatient(),
            'dateConsultation' => $entity->getDateConsultation()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Consultations 
            SET matriculeMedecin = :medecin, matriculePatient = :patient,
            dateConsultation = to_date(:dateConsultation, \'DD/MM/YYYY\')
            WHERE identifiant = :id');
        $count = $statement->execute(array(
            'id' => $entity->getIdentifiant(),
            'medecin' => $entity->getMatriculeMedecin(),
            'patient' => $entity->getMatriculePatient(),
            'dateConsultation' => $entity->getDateConsultation()));
        return $count;
    }

}

?>
