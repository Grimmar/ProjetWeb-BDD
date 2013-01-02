<?php

/**
 * Description of procedures
 *
 * @author Quentin
 */
require_once(ROOT . 'controllers\administrationController.php');

class Procedures extends AdministrationController {

    function index() {
        $this->render('index');
    }

}

?>
