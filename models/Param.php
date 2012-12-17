<?php

class Param {

    private $dbName;
    private $dbLocalisation;
    private $userName;
    private $userPassword;

    public function __construct($local, $dbn, $un, $p) {
        $this->dbLocalisation = $local;
        $this->dbName = $dbn;
        $this->userName = $un;
        $this->userPassword = $p;
    }

    public function getDbname() {
        return $this->dbname;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getUserPassword() {
        return $this->userPassword;
    }
    
    public function getDbLocalisation() {
        return $this->dbLocalisation;
    }


}

?>
