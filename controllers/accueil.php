<?php

/**
 * Description of accueil
 *
 * @author bissoqu1
 */
require_once(ROOT . 'controllers\userController.php');
class Accueil extends UserController {

    protected $models = array("medecin");

    function index() {
        if (!isset($_SESSION['user'])) {
            $this->forward("login");
        }
        $user = unserialize($_SESSION['user']);
        $this->set(array("user" => $user));
        $this->set(array("date" => date("d/m/Y")));
        $this->render('index');
    }

}

?>
