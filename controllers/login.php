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
            $user = $this->medecin->find(array("login=" => $_POST['login'],
                "motDePasse=" => $_POST['password']
                    ));
            $user = $user[0];
            //$user = new MedecinEntity("toto", "toto", "admin", "0", "toto", "toto", "toto", "toto", "toto",null);
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
        $this->set(array('user' => $user));
        if ($user->getRole() == "admin") {
            $_SESSION['user'] = serialize($user);
            $this->forward("medecin");
        }
        if ($user->getRole() == "medecin") {
            $_SESSION['user'] = serialize($user);
            $this->render("admin");
        }
    }

}

?>
