<?php

require_once(ROOT . 'controllers\administrationController.php');
class Admin extends AdministrationController {

    protected $models = array("medecin");

    function index() {
        $this->render('index');
    }

}

?>
