<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOConsultation
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/Consultation.php");

class DAOConsultation extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Consultations WHERE identifiant = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Consultations WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Consultation", array('identifiant', 'matriculeMedecin', 'matriculePatient', 'idMaladie', 'dateConsultation'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Consultations WHERE identifiant = :id');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $consult = new Consultation($donnee['identifiant'], $donnee['matriculeMedecin'], $donnee['matriculePatient'],
                            $donnee['idMaladie'], $donnee['dateConsultation']);
            return $consult;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Consultations (identifiant, matriculeMedecin, matriculePatient, idMaladie, dateConsultation) VALUES
			:identifiant, :matriculeMedecin, :matriculePatient, :idMaladie, :dateConsultation');

        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'matriculeMedecin' => $entity->getMatriculeMedecin(),
            'matriculePatient' => $entity->getMatriculePatient(),
            'idMaladie' => $entity->getIdMaladie(),
            'dateConsultation' => $entity->getDateConsultation()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Consultations SET matriculeMedecin = :matriculeMedecin, matriculePatient = :matriculePatient,
            idMalade = :idMaladie, dateConsultation = :dateConsultation
        and WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'matriculeMedecin' => $entity->getMatriculeMedecin(),
            'matriculePatient' => $entity->getMatriculePatient(),
            'idMaladie' => $entity->getIdMaladie(),
            'dateConsultation' => $entity->getDateConsultation()
                ));
        return $count;
    }

}

?>
