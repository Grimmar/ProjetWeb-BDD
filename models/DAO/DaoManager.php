<?php

include_once(ROOT . "models/Entite/MedecinEntity.php");
require_once(ROOT . "models/Param.php");

class DaoManager {

    private static $dao;
    private $connexion;
    private $oracleConnexion;

    private function __construct() {
        $this->createConnexion();
        $this->createOracleConnexion();
    }

    public static function getInstance() {
        if (self::$dao == null) {
            self::$dao = new DaoManager();
        }
        return self::$dao;
    }

    private function createConnexion() {
        $param = new param();
        try {
            $this->connexion = new PDO("oci:dbname=//" . $param->getDbLocalisation(), $param->getUserName(), $param->getUserPassword());
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connexion->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
            $this->connexion->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            if (!function_exists('oci_pconnect')) {
                $oracleConnexion = oci_pconnect($param->getUserName(), $param->getUserPassword(), $param->getDbLocalisation());
            } else {
                $oracleConnexion = null;
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getOracleConnexion() {
        return $this->oracleConnexion;
    }

    public function getConnexion() {
        return $this->connexion;
    }

    public static function testConnexion() {
        self::$dao = null;
        self::getInstance();
    }

    public static function isAdmin($pass) {
        $document_xml = new DomDocument();
        $document_xml->load(ROOT . "models/admin.xml");
        $password = $document_xml->getElementsByTagName('password');
        if ($password->item(0)->nodeValue == $pass) {
            return true;
        }
        return false;
    }

}

?>
