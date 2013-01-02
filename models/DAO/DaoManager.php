<?php

include_once(ROOT . "models/Entite/MedecinEntity.php");
require_once(ROOT . "models/Param.php");

class DaoManager {

    private static $dao;
    private $connexion;

    private function __construct() {
        $this->createConnexion();
    }

    public static function getInstance() {
        if (self::$dao == null) {
            self::$dao = new DaoManager();
        }
        return self::$dao;
    }

    private function createConnexion() {
        $param = new param("", "", "", "");
        try {
            $this->connexion = new PDO("oci:dbname=//" . $param->getDbLocalisation(), $param->getUserName(), $param->getUserPassword());
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connexion->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getConnexion() {
        return $this->connexion;
    }

}

?>
