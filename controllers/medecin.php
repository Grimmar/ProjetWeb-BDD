<?php

/**
 * Description of medecin
 *
 * @author bissoqu1
 */
require_once(ROOT . "models/Entite/AdresseTypeEntity.php");
require_once(ROOT . 'controllers/administrationController.php');

class Medecin extends AdministrationController {

    protected $models = array("medecin");

    function __construct() {
        parent::__construct();
    }

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
        if (isset($this->data) && !empty($this->data)) {
            $this->set(array("medecin" => $this->data));
        }
        $this->render('update');
    }

    function update($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $medecin = $this->medecin->get($matricule);
            if (isset($this->data) && !empty($this->data)) {
                $this->set(array("medecin" => $this->data, "matricule" => $matricule));
            } else {
                $this->set(array("medecin" => $medecin, "matricule" => $matricule));
            }
            $this->render('update');
        }
    }

    function delete($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $medecin = $this->medecin->get($matricule);
            $this->medecin->delete($matricule);
            $this->set(array("medecin" => $medecin));
            $this->render('delete');
        }
    }

    function addProccess() {
        echo 'avant';
        if (isset($this->data) && $this->filter() && !empty($_POST)) {
            $adresse = new AdresseTypeEntity($this->html($this->data['numero']),
                            $this->html($this->data['adresse']), $this->html($this->data['ville']),
                            $this->html($this->data['codePostal']));
            $medecin = new MedecinEntity($this->html($this->data['login']),
                            $this->html($this->data['md5']), "MEDECIN", null,
                            $this->html($this->data['nom']), $this->html($this->data['prenom']),
                            $this->html($this->data['telephone']), $this->html($this->data['secu']),
                            $this->html($this->data['dtns']), $adresse);
            $this->medecin->insert($medecin);
            echo 'forward';
            $this->forward("medecin/index");
        } else {
            $this->set($this->data);
            $this->render("add");
        }
    }

    function updateProccess($matricule) {
        if (isset($this->data) && $this->filter() && !empty($_POST)) {
            $adresse = new AdresseTypeEntity($this->html($this->data['numero']),
                            $this->html($this->data['adresse']), $this->html($this->data['ville']),
                            $this->html($this->data['codePostal']));
            $medecin = new MedecinEntity($this->html($this->data['login']),
                            $this->html($this->data['md5']), $this->role, $matricule,
                            $this->html($this->data['nom']), $this->html($this->data['prenom']),
                            $this->html($this->data['telephone']), $this->html($this->data['secu']),
                            $this->html($this->data['dtns']), $adresse);
            $this->medecin->update($medecin);
            $this->forward("medecin/index");
        } else {
            $this->set($this->data);
            $this->update($matricule);
        }
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
                $this->addMessage("Le numéro de téléphone est invalide.");
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
