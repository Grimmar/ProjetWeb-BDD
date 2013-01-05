<?php

/**
 * Description of procedures
 *
 * @author Quentin
 */
require_once(ROOT . 'controllers\administrationController.php');

class Procedures extends AdministrationController {

    protected $models = array('procedure', 'effetIndesirableOMS', 'medicament', 'patient', 'medecin', 'consultation', 'maladie', 'surveillance');

    function index() {
        $this->render('index');
    }

    function maladieToPatient($matricule = null, $maladie = null) {
        $patients = $this->patient->find(array("order by" => "nom"));
        $this->set(array("patients" => $patients));
        $this->render('maladieToPatient');
    }

    function medicamentsFromMaladie($idMaladie = null) {
        $meds = null;
        if (isset($idMaladie)) {
            $meds = $this->procedure->getMedicamentsFromMaladie($idMaladie);
        }

        if (!isset($meds)) {
            $maladies = $this->maladie->find(array("order by" => "libelle"));
            $this->set(array("maladies" => $maladies));
        } else {
            $array = array();
            $meds = $meds['CODECIS'];

            for ($i = 0; $i < count($meds); $i++) {
                $medicament = $this->medicament->get($meds[$i]);
                array_push($array, $medicament);
            }

            $this->set(array("medicaments" => $array));
        }
        $this->render('medicamentsFromMaladie');
    }

    function prescrireMedicament() {
        $this->render('prescrireMedicament');
    }

    function prescrireRecommendation() {
        $this->render('prescrireRecommendation');
    }

    function effetsMedicaments($codeCis = null) {
        $effets = null;
        if (isset($codeCis)) {
            $effets = $this->procedure->getEffetsIndesirablesFromMedicaments($codeCis);
        }

        if (!isset($effets)) {
            $medicaments = $this->medicament->find(array("order by" => "libelle"));
            $this->set(array("medicaments" => $medicaments));
        } else {
            $array = array();
            $effets = $effets['IDENTIFIANT'];

            for ($i = 0; $i < count($effets); $i++) {
                $effet = $this->medicament->get($effets[$i]);
                array_push($array, $effet);
            }

            $this->set(array("effets" => $array));
        }
        $this->render('effetsMedicaments');
    }

    function listPrescriptionDev() {
        $tab = $this->procedure->getMedicamentsPrescritParDeveloppeur();

        if ($tab != null) {
            $medicaments = array();
            if (!empty($tab['CODECIS'])) {
                $tab = $tab['CODECIS'];
                for ($i = 0; $i < count($tab); $i++) {
                    $medicament = $this->medicament->get($tab[$i]);
                    array_push($medicaments, $medicament);
                }
                $this->set(array("medicaments" => $medicaments));
            }
        }

        $this->render('listPrescriptionDev');
    }

    function listPrescriptionLab() {
        $tab = $this->procedure->getMedicamentsPrescritParDeveloppeurInLab();

        if ($tab != null) {
            $medicaments = array();
            if (!empty($tab['CODECIS'])) {
                $tab = $tab['CODECIS'];
                for ($i = 0; $i < count($tab); $i++) {
                    $medicament = $this->medicament->get($tab[$i]);
                    array_push($medicaments, $medicament);
                }
                $this->set(array("medicaments" => $medicaments));
            }
        }
        $this->render('listPrescriptionLab');
    }

    function possibleTraitement($matricule = null) {
        $tab = null;
        if ($matricule != NULL) {
            $tab = $this->procedure->getPossibleTreatment($matricule);
        }

        if (!isset($tab)) {
            $patients = $this->patient->find(array("order by" => "matricule"));
            $this->set(array("patients" => $patients));
        } else {
            $array = array();
            $tab = $tab['CODECIS'];

            for ($i = 0; $i < count($tab); $i++) {
                $medicament = $this->medicament->get($tab[$i]);
                array_push($array, $medicament);
            }

            $this->set(array("medicaments" => $array));
        }
        $this->render('possibleTraitement');
    }

    function watchDoctor($matricule = null) {
         $surveillance = null;
        if ($matricule != NULL) {
            $surveillance = $this->surveillance->get($matricule);
        }

        if (!isset($surveillance) && $matricule == NULL) {
            $medecins = $this->medecin->find(array("order by" => "matricule"));
            $this->set(array("medecins" => $medecins));
        } else {
            $array = array();
            print_r($surveillance);
            for ($i = 0; $i < count($surveillance); $i++) {
                $medicament = $this->medicament->get($surveillance[$i]);
                array_push($array, $medicament);
            }

            $this->set(array("surveillance" => $surveillance));
        }
        $this->render('watchDoctor');
    }

    function interactionTraitement() {
        $this->render('interactionTraitement');
    }

    function traitementCommuns() {
        $this->procedure->getTraitementsCommuns('MSH_D_001424', 'MSH_D_001424');
        $this->render('traitementCommuns');
    }

    function nouvelEffet() {
        $this->render('nouvelEffet');
    }

}

?>
