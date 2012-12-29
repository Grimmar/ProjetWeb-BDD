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
        $req = $this->bdd->prepare("DELETE FROM Patients WHERE matricule = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Patients WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "PatientEntity", array('matricule', 'nom', 'prenom', 'telephone', 'numeroSecu',
            'dateNaissance', 'adresse'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Patients WHERE matricule = :id');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $patient = new Patient($donnee['matricule'], $donnee['nom'], $donnee['prenom'],
                            $donnee['telephone'], $donnee['numeroSecu'], $donnee['dateNaissance'], $donnee['adresse']);
            return $patient;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Patients(matricule, nom, prenom, telephone, numeroSecu, dateNaissance, adresse) 
			VALUES(:login, :motDePasse, :matricule, :nom, :prenom, :telephone, :numeroSecu, :dateNaissance
                        , :adresse, Adresse_Type(:numero, :adresse, :ville, :codePostal))');

        $req->execute(array(
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
