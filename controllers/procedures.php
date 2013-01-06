<?php

/**
 * Description of procedures
 *
 * @author Quentin
 */
require_once(ROOT . 'controllers\administrationController.php');

class Procedures extends AdministrationController {

    protected $models = array('procedure', 'consultation', 'effetIndesirableOMS', 'medicament', 'patient', 'medecin', 'consultation', 'maladie', 'surveillance');

    function index() {
        $this->render('index');
    }

    function maladieToPatient($matricule = null, $maladie = null, $medecin = null) {
        if (isset($matricule) && isset($maladie) && isset($medecin)) {
            $this->procedure->affecterMaladiePatient($matricule, $medecin, $maladie);
            $this->set(array("maladie" => $maladie));
        } else if ($matricule == null) {
            $patients = $this->patient->find(array("order by" => "nom"));
            $this->set(array("patients" => $patients));
        } else if ($maladie == null) {
            $maladies = $this->maladie->find(array("order by" => "libelle"));
            $this->set(array("maladies" => $maladies));
            $this->set(array("matricule" => $matricule));
        } else {
            $medecins = $this->medecin->find(array("order by" => "nom"));
            $this->set(array("medecins" => $medecins));
            $this->set(array("maladie" => $maladie));
            $this->set(array("matricule" => $matricule));
        }
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

    private function filterMedicamentPrescription() {
        $f = true;
        if ($this->data['duration'] != null) {
            if (!is_numeric($this->data['duration'])) {
                $this->addMessage("La durée du traitement est invalide.");
                $f = false;
            }
        }
        return $f;
    }

    private function filterRecommendationPrescription() {
        $f = true;
        if ($this->data['duration'] != null) {
            if (!is_numeric($this->data['duration'])) {
                $this->addMessage("La durée du traitement est invalide.");
                $f = false;
            }
        }
        if ($this->data['recommendation'] == null) {
            $this->addMessage("La recommendation est obligatoire.");
            $f = false;
        }
        return $f;
    }

    function prescrireMedicament($patient = null) {
        if (!isset($patient)) {
            $patients = $this->patient->find(array("order by" => "nom"));
            $this->set(array("patients" => $patients));
        } else {
            $consult = $this->consultation->find(array("order by" => "dateConsultation",
                'matriculePatient=' => $patient));
            if (count($consult) != 0) {
                $medics = $this->medicament->find(array("order by" => "codeCis"));
                $this->set(array("medicaments" => $medics));
                $this->set(array("consult" => $consult[count($consult) - 1]->getIdentifiant()));
                $this->set(array("patient" => $patient));
            }
        }
        $this->render('prescrireMedicament');
    }

    function prescrireMedicamentProcess($patient) {
        if (isset($this->data) && $this->filterMedicamentPrescription() && !empty($_POST)) {
            $duration = $this->html($this->securite_bdd($this->data['duration']));
            $medocs = $this->html($this->securite_bdd($this->data['medicaments']));
            $consult = $this->html($this->securite_bdd($this->data['consult']));
            for ($i = 0; $i < count($medocs); $i++) {
                $this->procedure->prescrireMedicament($consult, $duration, $medocs[$i]);
            }
            $patient = null;
            $this->data = null;
            $this->set(array('success' => TRUE));
        }
        if ($this->data != null) {
            $this->set($this->data);
        }
        $this->render('prescrireMedicament');
    }

    function prescrireRecommendation($patient = null) {
        if (!isset($patient)) {
            $patients = $this->patient->find(array("order by" => "nom"));
            $this->set(array("patients" => $patients));
        } else {

            $consult = $this->consultation->find(array("order by" => "dateConsultation",
                'matriculePatient=' => $patient));
            $this->set(array("consult" => $consult[count($consult) - 1]));
            $this->set(array("patient" => $patient));
        }
        $this->render('prescrireRecommendation');
    }

    function prescrireRecommendationProcess($patient) {
        if (isset($this->data) && $this->filterRecommendationPrescription() && !empty($_POST)) {
            $duration = $this->html($this->securite_bdd($this->data['duration']));
            $recommendation = $this->html($this->securite_bdd($this->data['recommendation']));
            $consult = $this->html($this->securite_bdd($this->data['consult']));
            $this->procedure->prescrireRecommendation($consult, $duration, $recommendation);
            $patient = null;
            $this->data = null;
            $this->set(array('success' => TRUE));
        }
        if ($this->data != null) {
            $this->set($this->data);
        }
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
            for ($i = 0; $i < count($surveillance); $i++) {
                $medicament = $this->medicament->get($surveillance[$i]);
                array_push($array, $medicament);
            }

            $this->set(array("surveillance" => $surveillance));
        }
        $this->render('watchDoctor');
    }

    function interactionTraitement($mat = null) {
        if ($mat == NULL) {
            $patients = $this->patient->find(array("order by" => "matricule"));
            $this->set(array("patients" => $patients));
        } else {
            $medics = $this->medicament->find(array("order by" => "codeCis"));
            $this->set(array("medicaments" => $medics));
        }
        $this->render('interactionTraitement');
    }

    function interactionTraitementProcess($mat = null) {
        if (isset($mat) && isset($this->data['medicaments'])) {
            $interaction = $this->procedure->isInteractionsTraitement($mat, $this->data['medicaments']);
            $this->set(array('intExists' => $interaction['val'][0]));
        } else {
            $this->addMessage("Aucun patient ou médicament n'a été sélectionné.");
        }

        $this->render('interactionTraitement');
    }

    function traitementCommuns($maladie1 = null, $maladie2 = null) {
        if (isset($maladie1) && isset($maladie2)) {
            $medics = $this->procedure->getTraitementsCommuns($maladie1, $maladie2);
            $medicaments = array();
            for ($i = 0; $i < count($medics); $i++) {
                array_push($medicaments, $this->medicament->get($medics[$i]));
            }
            $this->set(array('medicaments' => $medicaments));
        }

        if ($maladie1 == NULL || $maladie2 == NULL) {
            $maladies = $this->maladie->find(array("order by" => "libelle"));
            $this->set(array("maladies" => $maladies));
            if ($maladie1 != NULL && $maladie2 == null) {
                $this->set(array('maladie1' => $maladie1));
            }
        }
        $this->render('traitementCommuns');
    }

    private function filterNouvelEffet() {
        $f = true;
        if ($this->data['effet'] == null) {
            $this->addMessage("Le nouvel effet est invalide.");
            $f = false;
        }
        return $f;
    }

    function nouvelEffet($med = null) {
        if (!isset($med)) {
            $medics = $this->medicament->find(array("order by" => "codeCis"));
            $this->set(array("medicaments" => $medics));
        } else {
            $this->set(array("medicament" => $med));
        }
        $this->render('nouvelEffet');
    }

    function nouvelEffetProcess() {
        if (isset($this->data) && $this->filterNouvelEffet() && !empty($_POST)) {
            $medicament = $this->html($this->securite_bdd($this->data['medicament']));
            $effet = $this->html($this->securite_bdd($this->data['effet']));
            $d = $this->procedure->insererNouvelEI($medicament, $effet); 
            if ($d != NULL) {
                $pats = $d['MATRICULEPATIENT'];
            }
            $patients = array();
            for ($i = 0; $i < count($pats); $i++) {
                array_push($patients, $this->patient->get($pats[$i]));
            }
            
            $this->set(array("patients" => $patients));
            $this->data = null;
        }
        if ($this->data != null) {
            $this->set($this->data);
        }
        $this->render('nouvelEffet');
    }

}

?>
