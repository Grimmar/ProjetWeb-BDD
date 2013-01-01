<?php
include_once(ROOT . "models/Entite/MedecinEntity.php");
require_once(ROOT . "models/Param.php");

class DAOManager {

    private static $dao;
    private $connexion;

    private function __construct() {
        $this->createConnexion();
    }

    public static function getInstance() {
        if (self::$dao == null) {
            self::$dao = new DAOManager();
        }
        return self::$dao;
    }

    private function createConnexion() {
        $param = new param("","","","");
        try {
            $this->connexion = new PDO("oci:dbname=//" . $param->getDbLocalisation(), $param->getUserName(), $param->getUserPassword());
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw $e;
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
        $user = new MedecinEntity("admin", "admin");


        return $user;
    }

}

?>
