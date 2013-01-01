<?php

/**
 * Description of login
 *
 * @author bissoqu1
 */
require_once(ROOT . "/models/DAO/DAOMedecin.php");

class login extends Controller {

    protected $models = array("medecin");

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
                "motDePasse=" => $_POST['password']));
            if ($user == NULL) {
                $this->render('index');
            } else {
                $user = $user[0];
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
            $this->forward("admin");
        } else if ($user->getRole() == "medecin") {
            $_SESSION['user'] = serialize($user);
            $this->render("accueil");
        } else {
            $_SESSION['user'] = null;
            session_destroy();
            $this->render("login");
        }
    }

}

?>
