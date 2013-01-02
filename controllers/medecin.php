<?php

/**
 * Description of medecin
 *
 * @author bissoqu1
 */
require_once(ROOT . "models/Entite/AdresseTypeEntity.php");
require_once(ROOT . 'controllers\administrationController.php');

class Medecin extends AdministrationController {

    protected $models = array("medecin");

    function index() {
        $medecins = $this->medecin->find(array("order by" => "nom"));
        $this->set(array("medecins" => $medecins));
        $this->render('index');
    }

    function view($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $medecin = $this->medecin->get($matricule);
            $d = array("medecin" => $medecin);
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
            $medecin = $this->medecin->get($matricule);
            $this->set(array("medecin" => $medecin, "matricule" => $matricule));
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

    function addProccess() {
        if (isset($this->data)) {
            $adresse = new AdresseTypeEntity($this->data['numero'],
                            $this->data['adresse'], $this->data['ville'],
                            $this->data['codePostal']);
            $medecin = new MedecinEntity($this->data['login'],
                            $this->data['password'], "medecin", null,
                            $this->data['nom'], $this->data['prenom'],
                            $this->data['telephone'], $this->data['secu'],
                            $this->data['dtns'], $adresse);
        }
        $this->medecin->insert($medecin);
        $this->forward("medecin/index");
    }

    function updateProccess($matricule) {
        $adresse = new AdresseTypeEntity($this->data['numero'],
                        $this->data['adresse'], $this->data['ville'],
                        $this->data['codePostal']);
        $medecin = new MedecinEntity($this->data['login'],
                        $this->data['password'], $this->role,
                        $matricule, $this->data['nom'], $this->data['prenom'],
                        $this->data['telephone'], $this->data['secu'],
                        $this->data['dtns'], $adresse);
        $this->medecin->update($medecin);
        $this->forward("medecin/index");
    }

}

?>
