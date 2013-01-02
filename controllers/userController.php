<?php

/**
 * Description of userController
 *
 * @author Quentin
 */
require_once(ROOT . 'controllers\identifiedController.php');

class userController extends IdentifiedController {

    public function __construct() {
        parent::__construct();
        if (!isset($this->user) || $this->user->getRole() !== "MEDECIN") {
            $this->forward("admin");
        }
    }

}

?>
