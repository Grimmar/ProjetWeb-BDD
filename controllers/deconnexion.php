<?php
require_once(ROOT . 'controllers\identifiedController.php');
class Deconnexion extends IdentifiedController {

    public function index() {
        session_destroy();
        $this->forward("login");
    }

}

?>
