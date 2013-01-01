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
require_once(ROOT . "models/Entite/ConsultationEntity.php");

class DAOConsultation extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        //$req = $this->bdd->prepare("DELETE FROM Consultations WHERE identifiant = :id");
        //$count = $req->execute(array("id" => $id));
        //return $count;
    }

    public function find($a) {
       $sqlrequest = "SELECT * FROM Consultations ";
        if ($a != null) {
            if (is_array($a)) {
                $sqlrequest .=$this->getWhereArray($a);
            } else {
                return null;
            }
        }
        $req = $this->bdd->prepare($sqlrequest);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($req as $data) {
            array_push($result, new ConsultationEntity($data->IDENTIFIANT, $data->MATRICULEMEDECIN,
                            $data->MATRICULEPATIENT, $data->DATECONSULTATION));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Consultations WHERE identifiant = :id');
        $req->execute(array(":id" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            return null;
        } else {
            return new ConsultationEntity($donnee[0]->IDENTIFIANT, $donnee[0]->MATRICULEMEDECIN,
                            $donnee[0]->MATRICULEPATIENT, $donnee[0]->DATECONSULTATION);
        }
    }

    public function insert($entity) {
        /* $req = $this->bdd->prepare('INSERT INTO Consultations (identifiant, MATRICULEMEDECIN, MATRICULEPATIENT, DATECONSULTATION) VALUES
          (:identifiant, :matriculeMedecin, :matriculePatient, :dateConsultation)');

          $req->execute(array(
          'identifiant' => $entity->getIdentifiant(),
          'matriculeMedecin' => $entity->getMatriculeMedecin(),
          'matriculePatient' => $entity->getMatriculePatient(),
          'dateConsultation' => $entity->getDateConsultation()
          )); */
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Consultations SET matriculeMedecin = :matriculeMedecin, matriculePatient = :matriculePatient,
            dateConsultation = :dateConsultation
        WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'matriculeMedecin' => $entity->getMatriculeMedecin(),
            'matriculePatient' => $entity->getMatriculePatient(),
            'dateConsultation' => $entity->getDateConsultation()
                ));
        return $count;
    }

}

?>
