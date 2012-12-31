<?php

require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT . "models/Entite/MedecinEntity.php");

class DAOMedecin extends AbstractDAO {

    //Select One
    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Medecins WHERE matricule = :id');
        $req->execute(array(":id" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            echo "ici !";
            return null;
        } else {
            var_dump($donnee);
            return new MedecinEntity($donnee[0]->login, $donnee[0]->motDePasse, $donnee[0]->role, $donnee[0]->matricule
                            , $donnee[0]->nom, $donnee[0]->prenom, $donnee[0]->telephone, $donnee[0]->numeroSecu, $donnee[0]->dateNaissance, $donnee[0]->adresse);
        }
    }

    //Select All With Criteria
    public function find($a) {
        $sqlrequest = "SELECT * FROM Medecins";
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
            array_push($result, new MedecinEntity($data->login, $data->motDePasse, $data->role, $data->matricule
                            , $data->nom, $data->prenom, $data->telephone, $data->numeroSecu, $data->dateNaissance,NULL));
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
            m.Adresse_type.numero = :numero, m.Adresse_type.adresse = :adresse,m.Adresse_type.ville = :ville,
            m.Adresse_type.codePostal = :codePostal WHERE matricule = :matricule');
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
