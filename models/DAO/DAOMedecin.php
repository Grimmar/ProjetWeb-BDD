<?php

require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT . "models/Entite/MedecinEntity.php");
require_once(ROOT . "models/Entite/Adresse_TypeEntity.php");

class DAOMedecin extends AbstractDAO {

    //Select One
    public function get($id) {
        $req = $this->bdd->prepare("SELECT LOGIN, MOTDEPASSE, ROLE, MATRICULE, NOM, PRENOM, TELEPHONE, NUMEROSECU, DATENAISSANCE
            , m.ADRESSE.NUMERO \"NUMERO\", m.ADRESSE.ADRESSE \"ADRESSE\", m.ADRESSE.VILLE \"VILLE\", m.ADRESSE.CODEPOSTAL \"CODEPOSTAL\" FROM Medecins m WHERE matricule = :id");
        $req->execute(array(":id" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            echo "ici !";
            return null;
        } else {
            return new MedecinEntity($donnee[0]->LOGIN, $donnee[0]->MOTDEPASSE, $donnee[0]->ROLE, $donnee[0]->MATRICULE
                            , $donnee[0]->NOM, $donnee[0]->PRENOM, $donnee[0]->TELEPHONE, $donnee[0]->NUMEROSECU, $donnee[0]->DATENAISSANCE, 
                    new Addresse_TypeEntity($donnee[0]->NUMERO, $donnee[0]->ADRESSE, $donnee[0]->VILLE,$donnee[0]->CODEPOSTAL));
        }
    }

    //Select All With Criteria
    public function find($a) {
        $sqlrequest = "SELECT LOGIN, MOTDEPASSE, ROLE, MATRICULE, NOM, PRENOM, TELEPHONE, NUMEROSECU, DATENAISSANCE
            , m.ADRESSE.NUMERO \"NUMERO\", m.ADRESSE.ADRESSE \"ADRESSE\", m.ADRESSE.VILLE \"VILLE\", m.ADRESSE.CODEPOSTAL \"CODEPOSTAL\" FROM Medecins m ";
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
            array_push($result, new MedecinEntity($data->LOGIN, $data->MOTDEPASSE, $data->ROLE, $data->MATRICULE
                            , $data->NOM, $data->PRENOM, $data->TELEPHONE, $data->NUMEROSECU, $data->DATENAISSANCE, 
                    new Addresse_TypeEntity($data->NUMERO, $data->ADRESSE, $data->VILLE, $data->CODEPOSTAL)));
        }
        return $result;
    }

    //Count
    public function count($entity) {
        
    }

    //Insert
    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Medecins(login, motDePasse, role,matricule, nom, prenom, telephone, numeroSecu, dateNaissance, adresse) 
			VALUES(:login, :motDePasse, :role, SEQUENCE_MEDECIN.nextval, :nom, :prenom, :telephone, :numeroSecu, :dateNaissance
                        , Adresse_Type(:numero, :adresse, :ville, :codePostal))');

        $req->execute(array(
            'login' => $entity->getLogin(),
            'motDePasse' => $entity->getMotDePasse(),
            'role' => "medecin",
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

    //Update
    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Medecins m SET login = :login, motDePasse = :motDePasse, nom = :nom, prenom = :prenom,
            telephone = :telephone, numeroSecu = :numeroSecu, dateNaissance = :dateNaissance, 
            m.Adresse.numero = :numero, m.Adresse.adresse = :adresse,m.Adresse.ville = :ville,
            m.Adresse.codePostal = :codePostal WHERE matricule = :matricule');
        $count = $req->execute(array(
            'login' => $entity->getLogin(),
            'motDePasse' => $entity->getMotDePasse(),
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

    //Delete
    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Medecins WHERE matricule = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

}

?>
