<?php

/**
 * Description of Administration
 *
 * @author Quentin
 */
require_once(ROOT . 'controllers\identifiedController.php');

class AdministrationController extends IdentifiedController {

    public function __construct() {
        parent::__construct();
        if (!isset($this->user) || $this->user->getRole() !== "ADMIN") {
            $this->forward("accueil");
        }
    }

}

?>
