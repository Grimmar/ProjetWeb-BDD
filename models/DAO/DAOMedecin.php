<?php

require_once("DAO.php");
require_once("DAOManager.php");
require_once("../Entite/Medecin.php");

class DAOMedecin implements DAO {

    private $dao;
    private $bdd;

    public function __construct() {
        $this->dao = DAOManager::getInstance();
        $this->bdd = $dao->getConnexion();
    }

    //Select One
    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Medecin WHERE matricule = :id');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $requ->fetch();
            $medecin = new Medecin($donnee['login'], $donnee['motDePasse'], $donnee);
            return $medecin;
        }
    }

    private function getWhereArray($whereArray) {
        $where = "";
        $finReq = "";
        foreach ($whereArray as $key => $value) {
            if (strpos($key, "order") !== FALSE || strpos($key, "LIMIT") !== FALSE) {
                $finReq .= $key . " " . $value . " ";
            } else {
                $where .= $key . " " . $value . " ";
            }
        }
        $where .= $finReq;
        return $where;
    }

    public function getWhereObjet($medecin) {
        //TODO : A TESTER !
        $where = "";
        for($medecin as $att) {
            $where .= $att . "=" . $val;
        }
    }

    //Select All With Criteria
    public function find($a) {
        if(!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Medecin WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Medecin", array('login', 'motDePasse', array('matricule', 'nom', 'prenom', 'telephone', 'numeroSecu',
                'dateNaissance', 'adresse')));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    //Count
    public function count($entity) {
        
    }

    //Insert
    public function insert($entity) {
        $req = $bdd->prepare('INSERT INTO Medecin(login, motDePasse, matricule, nom, prenom, telephone, numeroSecu, dateNaissance, adresse) 
			VALUES(:login, :motDePasse, :matricule, :nom, :prenom, :telephone, :numeroSecu, :dateNaissance, :adresse, Adresse_Type(:numero, :adresse, :ville, :codePostal))');

        $req->execute(array(
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
    }

    //Update
    public function update($entity) {
        
    }

    //Delete
    public function delete($id) {
        
    }

}

echo "kldfhlskdf";
//$daom = new DAOMedecin();
//$daom->getWhereObjet(new Medecin("tutu","sdkfklsd", array("nom"=>"alfred !")));
?>
