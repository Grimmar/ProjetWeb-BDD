<?php

class Param {

    private $dbName;
    private $dbLocalisation;
    private $userName;
    private $userPassword;

    public function __construct() {
        $document_xml = new DomDocument();
        $document_xml->load(ROOT . "models/config.xml");
        $dbName = $document_xml->getElementsByTagName('dbname');
        $dbport = $document_xml->getElementsByTagName('dbport');
        $userName = $document_xml->getElementsByTagName('name');
        $userPassword = $document_xml->getElementsByTagName('password');
        $this->dbLocalisation =   $dbName->item(0)->nodeValue.":".$dbport->item(0)->nodeValue;
        $this->dbName = "appweb";
        $this->userName = $userName->item(0)->nodeValue;
        $this->userPassword = $userPassword->item(0)->nodeValue;
    }

  
    public function getDbName() {
        return $this->dbName;
    }

    public function getDbLocalisation() {
        return $this->dbLocalisation;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getUserPassword() {
        return $this->userPassword;
    }



}

?>
