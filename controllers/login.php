<?php

/**
 * Description of login
 *
 * @author bissoqu1
 */
require_once(ROOT . "/models/DAO/DAOMedecin.php");
class login extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->dao = new DAOMedecin();
        $this->loadModel("medecin");
        session_start();
    }

    function index() {
        if (!isset($_SESSION['user'])) {
            $this->render('index');
        } else {
            $user = unserialize($_SESSION['user']);
            $this->redirect($user);
        }
    }

    function process() {
        if (isset($_POST['login']) && isset($_POST['password'])) {
            /*$user = $this->dao->find(array("login=" => $_POST['login'],
                "motDePass=" => $_POST['password']
                    ));*/
            $user = new MedecinEntity("toto", "toto", "medecin", "0", "toto", "toto", "toto", "toto", "toto",null);
            if ($user == NULL) {
                $this->render('index');
            } else {
               $this->redirect($user);
            }
        } else {
            $this->render('index');
        }
    }

    private function redirect($user) {
        if ($user->getRole() == "medecin") {
            $_SESSION['user'] = serialize($user);
            $this->forward("medecin");
        }
        if ($user->getRole() == "admin") {
            $_SESSION['user'] = serialize($user);
            $this->render("admin");
        }
    }

}

?>
