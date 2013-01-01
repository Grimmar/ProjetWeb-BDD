<?php

class patient extends Controller {

    protected $models = array("patient");

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
        $patients = $this->patient->find("");
        $this->set(array("patients" => $patients));
        $this->render('index');
    }

    function view($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $userDetail = $this->patient->get($matricule);
            $d = array("patient" => $userDetail);
            $this->set($d);
            $this->render('view');
        }
    }

    function add() {
        $this->render('update');
    }

    function update($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $userModif = $this->patient->get($matricule);
            $this->set(array("userModif" => $userModif, "matricule" => $matricule));
            $this->render('update');
        }
    }

    function delete($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $this->patient->delete($matricule);
            $this->render('delete');
        }
    }
        
    function addProccess() {
        $patient = new PatientEntity("", $_POST['nom']
                        , $_POST['prenom'], $_POST['telephone'], $_POST['secu'],
                        $_POST['dtns'], new Addresse_TypeEntity($_POST['numero'],
                                $_POST['adresse'], $_POST['ville'],
                                $_POST['codePostal']));
        $this->patient->insert($patient);
        $this->forward('patient/index');
    }

    function updateProccess($matricule) {
        $patient = new PatientEntity($matricule, $_POST['nom']
                        , $_POST['prenom'], $_POST['telephone'], $_POST['secu'], $_POST['dtns']
                        , new Addresse_TypeEntity($_POST['numero'], $_POST['adresse'], $_POST['ville'], $_POST['codePostal']));
        $this->patient->update($patient);
        $this->forward('patient/index');
    }

}

?>
