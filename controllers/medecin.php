<?php

/**
 * Description of medecin
 *
 * @author bissoqu1
 */
require_once(ROOT . "models/Entite/Adresse_TypeEntity.php");

class medecin extends Controller {

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
        $medecins = $this->medecin->find(array("order by"=>"matricule"));
        $this->set(array("medecins" => $medecins));
        $this->render('index');
    }

    function view($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $userDetail = $this->medecin->get($matricule);
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
            $this->set(array("userModif" => $userModif, "matricule" => $matricule));
            $this->render('update');
        }
    }

    function delete($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $this->medecin->delete($matricule);
            $this->render('delete');
        }
    }

}

?>
