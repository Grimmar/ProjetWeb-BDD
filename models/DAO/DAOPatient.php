<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOPatient
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/PatientEntity.php");

class DAOPatient extends AbstractDAO {

    //put your code here
    public function count($entity) {
        
    }

    public function delete($id) {
       /* $req = $this->bdd->prepare("DELETE FROM Patients WHERE matricule = :id");
        $count = $req->execute(array("id" => $id));
        return $count;*/
    }

    public function find($a) {
       $sqlrequest = "SELECT * FROM Patients";
        if ($a != null) {
            if (is_array($a)) {
                $sqlrequest .=" where " . $this->getWhereArray($a);
            } else {
                return null;
            }
        }
        $req = $this->bdd->prepare($sqlrequest);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($req as $data) {
            array_push($result, new PatientEntity( $data->matricule
                            , $data->nom, $data->prenom, $data->telephone, $data->numeroSecu, $data->dateNaissance, $data->adresse));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Patients WHERE matricule = :id');
        $req->execute(array(":id" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            echo "ici !";
            return null;
        } else {
            var_dump($donnee);
            return new PatientEntity( $donnee[0]->matricule
                            , $donnee[0]->nom, $donnee[0]->prenom, $donnee[0]->telephone, $donnee[0]->numeroSecu, $donnee[0]->dateNaissance, $donnee[0]->adresse);
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Patients(matricule, nom, prenom, telephone, numeroSecu, dateNaissance, adresse) 
			VALUES( SEQUENCE_PATIENT.nextval, :nom, :prenom, :telephone, :numeroSecu, :dateNaissance
                        ,  Adresse_Type(:numero, :adresse, :ville, :codePostal))');

        $req->execute(array(
            'nom' => $entity->getNom(),
            'prenom' => $entity->getPrenom(),
            'telephone' => $entity->getTelephone(),
            'numeroSecu' => $entity->getNumeroSecu(),
            'dateNaissance' => $entity->getDateNaissance(),
            'numero' => $entity->getAdresse()->getNumero(),
            'adresse' => $entity->getAdresse()->getAdresse(),
            'ville' => $entity->getAdresse()->getVille(),
            'codePostal' => $entity->getAdresse()->getCodePostal()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Patients p SET nom = :nom, prenom = :prenom,
            telephone = :telephone, numeroSecu = :numeroSecu, dateNaissance = :dateNaissance, 
            p.Adresse_type.numero = :numero, p.Adresse_type.adresse = :adresse, p.Adresse_type.ville = :ville,
            p.Adresse_type.codePostal = :codePostal
        WHERE matricule = :matricule');

        $count = $req->execute(array(
            'matricule' => $entity->getMatricule(),
            'nom' => $entity->getNom(),
            'prenom' => $entity->getPrenom(),
            'telephone' => $entity->getTelephone(),
            'numeroSecu' => $entity->getNumeroSecu(),
            'dateNaissance' => $entity->getDateNaissance(),
            'numero' => $entity->getAdresse()->getNumero(),
            'adresse' => $entity->getAdresse()->getAdresse(),
            'ville' => $entity->getAdresse()->getVille(),
            'codePostal' => $entity->getAdresse()->getCodePostal()
                ));
        return $count;
    }

}

?>
