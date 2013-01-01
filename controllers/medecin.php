<?php

/**
 * Description of medecin
 *
 * @author bissoqu1
 */
require_once(ROOT . "models/Entite/Adresse_TypeEntity.php");

class medecin extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("medecin");
        //$this->medecin = new DAOMedecin();
        session_start();
        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            $this->set(array("user" => $user));
        } else {
            $this->forward("login");
        }
    }

    function index() {
        $medecins = $this->medecin->find(array("order by"=>"matricule"));
        /*$user = new MedecinEntity("toto", "toto", "medecin", "0", "toto", "toto", "toto", "toto", "toto", null);
        $user2 = new MedecinEntity("toto", "toto", "medecin", "5", "titi", "titi", "toto", "toto", "toto", null);
        $medecins = array($user, $user2);*/
        $this->set(array("medecins" => $medecins));
        $this->render('index');
    }

    function view($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $userDetail = $this->medecin->get($matricule);
            // $userDetail = new MedecinEntity("toto", "toto", "medecin", "5", "titi", "titi", "toto", "toto", "toto", null);
            $d = array("medecin" => $userDetail);
            $this->set($d);
            $this->render('view');
        }
    }

    function add() {
        $this->render('update');
    }

    function addProccess() {
        $medecin = new MedecinEntity($_POST['login'], $_POST['password'], "medecin", "", $_POST['nom']
                        , $_POST['prenom'], $_POST['telephone'], $_POST['secu'], $_POST['dtns']
                        , new Addresse_TypeEntity($_POST['numero'], $_POST['adresse'], $_POST['ville'], $_POST['codePostal']));
        $this->medecin->insert($medecin);
        $this->forward("medecin/index");
    }

    function updateProccess($matricule) {
        $medecin = new MedecinEntity($_POST['login'], $_POST['password'], "medecin", $matricule, $_POST['nom']
                        , $_POST['prenom'], $_POST['telephone'], $_POST['secu'], $_POST['dtns']
                        , new Addresse_TypeEntity($_POST['numero'], $_POST['adresse'], $_POST['ville'], $_POST['codePostal']));
        $this->medecin->update($medecin);
        $this->forward("medecin/index");
    }

    function update($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $userModif = $this->medecin->get($matricule);
            //$userModif = new MedecinEntity("toto", "toto", "medecin", "5", "titi", "titi", "toto", "toto", "toto", new Addresse_TypeEntity("pouet","pouet2", "pouet3", "pouet4"));
            $this->set(array("userModif" => $userModif, "matricule" => $matricule));
            $this->render('update');
        }
    }

    function delete($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $this->medecin->delete($matricule);
            /* $d = array('matricule' => $matricule);
              $this->set($d); */
            $this->render('delete');
        }
    }

}

?>
