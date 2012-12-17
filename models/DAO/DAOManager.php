<?php

include_once("DAO.php");
include_once(ROOT . "models/Entite/Medecin.php");

class DAOManager {

    private static $dao;
    private $connexion;

    private function __construct() {
        createConnexion();
    }

    public static function getInstance() {
        if (self::$dao == null) {
            self::$dao = new DAOManager();
        }
        return self::$dao;
    }

    private function createConnexion() {
        $param = new param();
        try {
            $this->connexion = new PDO("oci:dbname=//" . $param->getDbLocalisaion() . "/" . $param->getDbName, $param->getLogin(), $param->getMdp());
        } catch (PDOException $e) {
            echo "Erreur !: " . $e->getMessage() . "<br/>";
        }
    }

    public function getConnexion(){
        return $this->connexion;
    }

    private function getAuthentification($login, $pass) {
        /* if($this->connexion == null){
          getConnexion();
          }
          $pass= ICI METTRE L'ALGO DE CRYPTAGE!
          $rp=$this->connexion->prepare("SELECT * from Medecins WHERE Login = :login and mdp = :pass"); // on prépare notre requête
          $rp->execute(array( 'login' => $user, 'pass' =$mdp )); */
        $user = new Medecin("admin", "admin");


        return $user;
    }

}

?>
