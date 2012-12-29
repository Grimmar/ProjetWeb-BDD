<?php

require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/MedecinEntity.php");

class DAOMedecin extends AbstractDAO {

    //Select One
    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Medecins WHERE matricule = :id');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $medecin = new Medecin($donnee['login'], $donnee['motDePasse'], $donnee['matricule'], $donnee['nom'], $donnee['prenom'],
                            $donnee['telephone'], $donnee['numeroSecu'], $donnee['dateNaissance'], $donnee['adresse']);
            return $medecin;
        }
    }

    //Select All With Criteria
    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Medecins WHERE :where');
        $where = parent::getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "MedecinEntity", array('login', 'motDePasse', 'matricule', 'nom', 'prenom', 'telephone', 'numeroSecu',
            'dateNaissance', 'adresse'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    //Count
    public function count($entity) {
        
    }

    //Insert
    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Medecins(login, motDePasse, role,matricule, nom, prenom, telephone, numeroSecu, dateNaissance, adresse) 
			VALUES(:login, :motDePasse, :role, :matricule, :nom, :prenom, :telephone, :numeroSecu, :dateNaissance
                        , :adresse, Adresse_Type(:numero, :adresse, :ville, :codePostal))');

        $req->execute(array(
            'login' => $entity->getLogin(),
            'motDePasse' => $entity->getMotDePasse(),
            'role' => "medecin",
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
