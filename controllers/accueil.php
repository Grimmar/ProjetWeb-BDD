<?php

/**
 * Description of accueil
 *
 * @author bissoqu1
 */
require_once(ROOT . 'controllers\identifiedController.php');
class Accueil extends Controller {

    protected $models = array("medecin");

    public function __construct() {
        parent::__construct();
        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            $this->set(array("user" => $user));
        } else {
            $this->forward("login");
        }
    }

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
