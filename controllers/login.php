<?php

/**
 * Description of login
 *
 * @author bissoqu1
 */
class Login extends Controller {

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
        var_dump($_POST);
        echo md5("raoul");
        if (isset($_POST['login']) && isset($_POST['md5'])) {
            $user = $this->medecin->find(array("login=" => $_POST['login'],
                "motDePasse=" => $_POST['md5']));
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
        if ($user->getRole() == "ADMIN") {
            $_SESSION['user'] = serialize($user);
            $this->forward("admin");
        } else if ($user->getRole() == "MEDECIN") {
            $_SESSION['user'] = serialize($user);
            $this->forward("accueil");
        } else {
            $_SESSION['user'] = null;
            session_destroy();
            $this->render("index");
        }
    }

}

?>
