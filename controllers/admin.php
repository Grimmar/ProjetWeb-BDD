<?php

require_once(ROOT . 'controllers\identifiedController.php');
class Admin extends IdentifiedController {

    protected $models = array("medecin");

    function index() {
        $this->render('index');
    }

}

?>
