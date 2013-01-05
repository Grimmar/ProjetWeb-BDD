<?php

/**
 * Description of procedures
 *
 * @author Quentin
 */
require_once(ROOT . 'controllers\administrationController.php');

class Procedures extends AdministrationController {

    protected $models = array('procedure', 'patient', 'consultation', 'maladie', 'surveillance');

    function index() {
        $this->render('index');
    }

    function maladieToPatient($matricule = null, $maladie = null) {
        $patients = $this->patient->find(array("order by" => "nom"));
        $this->set(array("patients" => $patients));
        $this->render('maladieToPatient');
    }

    function medicamentsFromMaladie() {
        $this->procedure->getMedicamentsFromMaladie('MSH_D_001424');
        /*$maladies = $this->maladie->find(array("order by" => "libelle"));
        $this->set(array("maladies" => $maladies));
        $this->render('medicamentsFromMaladie');*/
    }

    function prescrireMedicament() {
        $this->render('prescrireMedicament');
    }

    function prescrireRecommendation() {
        $this->render('prescrireRecommendation');
    }

    function effetsMedicaments() {
        $this->render('effetsMedicaments');
    }

    function listPrescriptionDev() {
        $this->render('listPrescriptionDev');
    }

    function listPrescriptionLab() {
        $this->render('listPrescriptionLab');
    }

    function possibleTraitement() {
        $this->render('possibleTraitement');
    }

    function watchDoctor() {
        $this->render('watchDoctor');
    }

    function interactionTraitement() {
        $this->render('interactionTraitement');
    }

    function traitementCommuns() {
        $this->render('traitementCommuns');
    }

    function nouvelEffet() {
        $this->render('nouvelEffet');
    }

}

?>
