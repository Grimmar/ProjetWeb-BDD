<?php

/**
 * Description of PatientDao
 *
 * @author david
 */
//TODO Caractéristiques + Maladies chroniques
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/PatientEntity.php");
require_once(ROOT . "models/Entite/AdresseTypeEntity.php");
require_once(ROOT . "models/Entite/CaracteristiqueEntity.php");
require_once(ROOT . "models/Entite/MaladieChroniqueEntity.php");

class PatientDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT * FROM Patients ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement::rowCount();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Patients 
            WHERE matricule = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT matricule, nom, prenom, telephone, numeroSecu,
            dateNaissance, m.adresse.numero \"numero\",
            m.adresse.adresse \"adresse\", m.adresse.ville \"ville\",
            m.adresse.codePostal \"codePostal\" FROM Patients m ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            $adresse = new AdresseTypeEntity($d->numero,
                            $d->adresse, $d->ville, $d->codepostal);
            $patient = new PatientEntity($d->matricule, $d->nom,
                            $d->prenom, $d->telephone, $d->numerosecu,
                            $d->datenaissance, $adresse);
            array_push($result, $patient);
            unset($adresse);
            unset($patient);
        }
        return $result;
    }

    public function get($id) {
        $sql = "SELECT matricule, nom, prenom, telephone, numeroSecu,
            dateNaissance, m.adresse.numero \"numero\",
            m.adresse.adresse \"adresse\", m.adresse.ville \"ville\",
            m.adresse.codePostal \"codePostal\" FROM Patients m 
            WHERE matricule = :id";

        $statement = $this->bdd->prepare($sql);
        $statement->execute(array(":id" => $id));
        $d = $statement->fetchAll(PDO::FETCH_OBJ);
        if ($statement::rowCount() != 1) {
            return null;
        }
        return new PatientEntity($d[0]->matricule, $d[0]->nom, $d[0]->prenom,
                        $d[0]->telephone, $d[0]->numerosecu,
                        $d[0]->datenaissance, new AdresseTypeEntity(
                                $d[0]->numero, $d[0]->adresse, $d[0]->ville,
                                $d[0]->codepostal));
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Patients(nom, prenom, 
            telephone, numeroSecu, dateNaissance, adresse) VALUES(:nom, :prenom,
            :telephone, :numeroSecu, to_date(:dateNaissance, \'DD/MM/YYYY\'),
            Adresse_Type(:numero, :adresse, :ville, :codePostal))');

        $statement->execute(array(
            'nom' => $entity->getNom(),
            'prenom' => $entity->getPrenom(),
            'telephone' => $entity->getTelephone(),
            'numeroSecu' => $entity->getNumeroSecu(),
            'dateNaissance' => $entity->getDateNaissance(),
            'numero' => $entity->getAdresse()->getNumero(),
            'adresse' => $entity->getAdresse()->getAdresse(),
            'ville' => $entity->getAdresse()->getVille(),
            'codePostal' => $entity->getAdresse()->getCodePostal()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Patients p SET nom = :nom,
            prenom = :prenom, telephone = :telephone, numeroSecu = :numeroSecu,
            dateNaissance = to_date(:dateNaissance, \'DD/MM/YYYY\'),
            p.Adresse.numero = :numero, p.Adresse.adresse = :adresse,
            p.Adresse.ville = :ville, p.Adresse.codePostal = :codePostal
            WHERE matricule = :matricule');

        $count = $statement->execute(array(
            'matricule' => $entity->getMatricule(),
            'nom' => $entity->getNom(),
            'prenom' => $entity->getPrenom(),
            'telephone' => $entity->getTelephone(),
            'numeroSecu' => $entity->getNumeroSecu(),
            'dateNaissance' => $entity->getDateNaissance(),
            'numero' => $entity->getAdresse()->getNumero(),
            'adresse' => $entity->getAdresse()->getAdresse(),
            'ville' => $entity->getAdresse()->getVille(),
            'codePostal' => $entity->getAdresse()->getCodePostal()));
        return $count;
    }

}

?>
