<?php

/**
 * Description of DAOPatient
 *
 * @author david
 */
require_once ("AbstractDAO.php");
require_once(ROOT . "models/Entite/PatientEntity.php");
require_once(ROOT . "models/Entite/Adresse_TypeEntity.php");

class DAOPatient extends AbstractDAO {

    //put your code here
    public function count() {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Patients WHERE matricule = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        $sqlrequest = "SELECT MATRICULE, NOM, PRENOM, TELEPHONE, NUMEROSECU,
            DATENAISSANCE, m.ADRESSE.NUMERO \"NUMERO\",
            m.ADRESSE.ADRESSE \"ADRESSE\", m.ADRESSE.VILLE \"VILLE\",
            m.ADRESSE.CODEPOSTAL \"CODEPOSTAL\" FROM Patients m ";
        if ($a != null) {
            if (is_array($a)) {
                $sqlrequest .= $this->getWhereArray($a);
            } else {
                return null;
            }
        }
        $req = $this->bdd->prepare($sqlrequest);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($req as $data) {
            array_push($result, new PatientEntity($data->MATRICULE, $data->NOM,
                            $data->PRENOM, $data->TELEPHONE, $data->NUMEROSECU,
                            $data->DATENAISSANCE, new Addresse_TypeEntity($data->NUMERO,
                                    $data->ADRESSE, $data->VILLE, $data->CODEPOSTAL)));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare("SELECT MATRICULE, NOM, PRENOM, TELEPHONE, 
              NUMEROSECU, DATENAISSANCE, m.ADRESSE.NUMERO \"NUMERO\",
              m.ADRESSE.ADRESSE \"ADRESSE\", m.ADRESSE.VILLE \"VILLE\",
              m.ADRESSE.CODEPOSTAL \"CODEPOSTAL\"
              FROM Patients m WHERE matricule = :id");
        $req->execute(array(":id" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            echo "ici !";
            return null;
        } else {
            return new PatientEntity($donnee[0]->MATRICULE, $donnee[0]->NOM,
                            $donnee[0]->PRENOM, $donnee[0]->TELEPHONE,
                            $donnee[0]->NUMEROSECU, $donnee[0]->DATENAISSANCE,
                            new Addresse_TypeEntity($donnee[0]->NUMERO,
                                    $donnee[0]->ADRESSE, $donnee[0]->VILLE,
                                    $donnee[0]->CODEPOSTAL));
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Patients(nom, prenom, telephone,
            numeroSecu, dateNaissance, adresse) VALUES(:nom, :prenom,
            :telephone, :numeroSecu, :dateNaissance,
            Adresse_Type(:numero, :adresse, :ville, :codePostal))');

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
        $req = $this->bdd->prepare('UPDATE Patients p SET nom = :nom,
            prenom = :prenom, telephone = :telephone, numeroSecu = :numeroSecu,
            dateNaissance = :dateNaissance, p.Adresse.numero = :numero,
            p.Adresse.adresse = :adresse, p.Adresse.ville = :ville,
            p.Adresse.codePostal = :codePostal WHERE matricule = :matricule');

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
