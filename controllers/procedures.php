<?php

/**
 * Description of procedures
 *
 * @author Quentin
 */
require_once(ROOT . 'controllers\identifiedController.php');

class Procedures extends IdentifiedController {

    function index() {
        $this->render('index');
    }

}

?>
