<?php

class Param {

    private $dbName;
    private $dbLocalisation;
    private $userName;
    private $userPassword;

    public function __construct($local, $dbn, $un, $p) {
        $this->dbLocalisation = "127.0.0.1:1521";
        $this->dbName = "appweb";
        $this->userName = "appweb";
        $this->userPassword = "appweb";
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
