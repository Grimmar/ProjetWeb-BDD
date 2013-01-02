<?php

require_once(ROOT . 'controllers\identifiedController.php');
class Patient extends IdentifiedController {

    protected $models = array("patient");

    function index() {
        $patients = $this->patient->find(array("order by" => "matricule"));
        $this->set(array("patients" => $patients));
        $this->render('index');
    }

    function view($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $patient = $this->patient->get($matricule);
            $d = array("patient" => $patient);
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
            $patient = $this->patient->get($matricule);
            $this->set(array("patient" => $patient, "matricule" => $matricule));
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
        $adresse = new AdresseTypeEntity($this->data['numero'],
                        $this->data['adresse'], $this->data['ville'],
                        $this->data['codePostal']);
        $patient = new PatientEntity(null, $this->data['nom'],
                        $this->data['prenom'], $this->data['telephone'],
                        $this->data['secu'], $this->data['dtns'], $adresse);
        $this->patient->insert($patient);
        $this->forward('patient/index');
    }

    function updateProccess($matricule) {
        $adresse = new AdresseTypeEntity($this->data['numero'],
                        $this->data['adresse'], $this->data['ville'],
                        $this->data['codePostal']);

        $patient = new PatientEntity($matricule, $this->data['nom'],
                        $this->data['prenom'], $this->data['telephone'],
                        $this->data['secu'], $_POST['dtns'], $adresse);
        $this->patient->update($patient);
        $this->forward('patient/index');
    }

}

?>
