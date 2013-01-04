<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfigurationBDD
 *
 * @author David
 */
require_once(ROOT . 'controllers\administrationController.php');
require_once(ROOT . 'models\DAO\DaoManager.php');

class ConfigurationBDD extends Controller {

    private $fichier;
    
    public function __construct() {
        parent::__construct();
        $this->fichier = ROOT . "models/config.xml";
    }

    function index() {
        $document_xml = new DomDocument();
        $document_xml->load($this->fichier);
        $dbName = $document_xml->getElementsByTagName('dbname');
        $dbport = $document_xml->getElementsByTagName('dbport');
        $userName = $document_xml->getElementsByTagName('name');
        $userPassword = $document_xml->getElementsByTagName('password');
        $data = array("dbName" => $dbName->item(0)->nodeValue,
            "dbport" => $dbport->item(0)->nodeValue,
            "userName" => $userName->item(0)->nodeValue,
            "userPassword" => $userPassword->item(0)->nodeValue);
        $this->set($data);
        $this->render('index');
    }

    function updateProccess() {
        $document_xml = new DomDocument();
        $document_xml->load($this->fichier);
        $dbName = $document_xml->getElementsByTagName('dbname');
        $dbport = $document_xml->getElementsByTagName('dbport');
        $userName = $document_xml->getElementsByTagName('name');
        $userPassword = $document_xml->getElementsByTagName('password');
        $dbName->item(0)->nodeValue = $_POST["dbName"];
        $dbport->item(0)->nodeValue = $_POST["port"];
        $userName->item(0)->nodeValue = $_POST["user"];
        $userPassword->item(0)->nodeValue = $_POST["password"];
        $document_xml->save(ROOT . "models/config.xml");
        $this->testConnexion();
        $data = array("dbName" => $dbName->item(0)->nodeValue,
            "dbport" => $dbport->item(0)->nodeValue,
            "userName" => $userName->item(0)->nodeValue,
            "userPassword" => $userPassword->item(0)->nodeValue);
        $this->set($data);
        $this->render('index');
    }

    function testConnexion() {
        try {
            DaoManager::testConnexion();
            $this->set(array("connexion" => true));
        } catch (PDOException $e) {
            $this->set(array("connexion" => false));
        }
    }

}

?>
