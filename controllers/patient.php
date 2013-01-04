<?php

require_once(ROOT . 'controllers\administrationController.php');

class Patient extends AdministrationController {

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
        if (isset($this->data) && $this->filter()) {
            $adresse = new AdresseTypeEntity($this->data['numero'],
                            $this->data['adresse'], $this->data['ville'],
                            $this->data['codePostal']);
            $patient = new PatientEntity(null, $this->data['nom'],
                            $this->data['prenom'], $this->data['telephone'],
                            $this->data['secu'], $this->data['dtns'], $adresse);
            $this->patient->insert($patient);
            $this->forward('patient/index');
        }
        $this->render('update');
    }

    function updateProccess($matricule) {
        if (isset($this->data) && $this->filter()) {
            $adresse = new AdresseTypeEntity($this->data['numero'],
                            $this->data['adresse'], $this->data['ville'],
                            $this->data['codePostal']);

            $patient = new PatientEntity($matricule, $this->data['nom'],
                            $this->data['prenom'], $this->data['telephone'],
                            $this->data['secu'], $_POST['dtns'], $adresse);
            $this->patient->update($patient);
            $this->forward('patient/index');
        }
        $this->render('update');
    }

    function filter() {
        $f = true;
        if ($this->data['numero'] != null) {
            if (!is_numeric($this->data['numero'])) {
                $this->addMessage("Le numéro de l'adresse est invalide.");
                $f = false;
            }
        }
        if ($this->data['codePostal'] != null) {
            if (!is_numeric($this->data['codePostal'])) {
                $this->addMessage("Le code postal est invalide.");
                $f = false;
            }
        }
        if ($this->data['telephone'] != null) {
            if (!is_numeric($this->data['telephone'])) {
                $this->addMessage("Le numéro de télèphone est invalide.");
                $f = false;
            }
        }
        if ($this->data['secu'] != null) {
            if (!is_numeric($this->data['secu'])) {
                $this->addMessage("Le numéro de securité social est invalide.");
                $f = false;
            }
        }
        if ($this->data['dtns'] != null) {
            if (preg_match('`^\d{1,2}/\d{1,2}/\d{4}$`', $this->data['dtns'])) {
                $date = explode("/", $this->data['dtns']);
                if (!checkdate($date[1], $date[0], $date[2])) {
                    $this->addMessage("La date de naissance est invalide.");
                    $f = false;
                }
            } else {
                $this->addMessage("La date de naissance est invalide.");
                $f = false;
            }
        }
        return $f;
    }

}

?>
