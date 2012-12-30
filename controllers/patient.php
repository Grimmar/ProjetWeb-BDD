<?php

class patient extends Controller {

    public function __construct() {
        parent::__construct();
        $this->loadModel("patient");
        session_start();
        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            $this->set(array("user" => $user));
        } else {
            $this->forward("login");
        }
    }

    function index() {
        $patients = $this->patient->find("");
        $user = new PatientEntity("0", "toto", "toto", "toto", "toto", "toto", null);
        $user2 = new PatientEntity("5", "titi", "titi", "toto", "toto", "toto", null);
        $patients = array($user, $user2);
        $this->set(array("patients" => $patients));
        $this->render('index');
    }

    function view($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $userDetail = $this->patient->get($matricule);
            //$userDetail = new PatientEntity("5", "titi", "titi", "toto", "toto", "toto", null);
            $d = array("patient" => $userDetail);
            $this->set($d);
            $this->render('view');
        }
    }

    function add() {
        $this->render('update');
    }

    function addProccess() {
        $medecin = new PatientEntity("", $_POST['nom']
                        , $_POST['prenom'], $_POST['telephone'], $_POST['secu'], $_POST['dtns']
                        , new Addresse_Type($_POST['numero'], $_POST['adresse'], $_POST['ville'], $_POST['codePostal']));
        $this->patient->insert($medecin);
        $this->forward("patient/index");
    }

    function updateProccess($matricule) {
        $patient = new PatientEntity($matricule, $_POST['nom']
                        , $_POST['prenom'], $_POST['telephone'], $_POST['secu'], $_POST['dtns']
                        , new Addresse_Type($_POST['numero'], $_POST['adresse'], $_POST['ville'], $_POST['codePostal']));
        $this->patient->update($patient);
        $this->forward("patient/index");
    }

    function update($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $userModif = $this->patient->get($matricule);
            //$userModif = new PatientEntity("toto", "toto", "medecin", "5", "titi", "titi", "toto", "toto", "toto", new Addresse_TypeEntity("pouet","pouet2", "pouet3", "pouet4"));
            $this->set(array("userModif" => $userModif, "matricule" => $matricule));
            $this->render('update');
        }
    }

    function delete($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $this->patient->delete($matricule);
            /* $d = array('matricule' => $matricule);
              $this->set($d); */
            $this->render('delete');
        }
    }

}

?>
