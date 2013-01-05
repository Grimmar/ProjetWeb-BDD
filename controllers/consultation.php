<?php

/**
 * Description of consultation
 *
 * @author bissoqu1
 */
require_once(ROOT . 'controllers\userController.php');
require_once(ROOT . 'models\DAO\DaoManager.php');

class consultation extends UserController {

    protected $models = array("consultation", "patient", "symptome", "maladie", "medicament","procedure");
    private $symp;

    function __construct() {
        parent::__construct();
        $this->symp = array();
    }

    function index() {
        $patients = $this->patient->find(array("order by" => "matricule"));
        $this->set(array("patients" => $patients));
        //var_dump($_SESSION);
        $_SESSION['patient'] = NULL;
        $_SESSION['symptomes'] = NULL;
        $_SESSION['maladie'] = NULL;
        $this->render("index");
    }

    function filter() {
        $patients = $this->patient->find(array("nom=" => $_POST['nom']));
        //var_dump($patients);
        $this->set(array("patients" => $patients));
        $this->render("index");
    }

    function symptomeProccess($matricule) {
        $p = $this->patient->get($matricule);
        $_SESSION['patient'] = serialize($p);
        $this->set(array("patientSelect" => $p));
        $symp = $this->symptome->find("");
        $this->set(array("symptome" => $symp));
        $this->render("symptome");
    }

    function addSymptome() {
        $this->symptome->insert(new SymptomeEntity(null, $_POST['lib_symptome']));
        $symp = $this->symptome->find("");
        $this->set(array("symptome" => $symp));
        $this->render("symptome");
    }

    function selectSymptome($matricule) {
        if (!isset($_SESSION['symptomes'])) {
            $_SESSION['symptomes'] = array();
        }
        $s = $this->symptome->get($matricule);
        if (!in_array(serialize($s), $_SESSION['symptomes']))
            array_push($_SESSION['symptomes'], serialize($s));
        
        $symp = $this->symptome->find("");
        $this->set(array("symptome" => $symp, "symptomepatient" => $this->unserializableArray($_SESSION['symptomes'])));
        $this->render("symptome");
    }

    function removeSymptome($matricule) {
        if (!isset($_SESSION['symptomes'])) {
            $_SESSION['symptomes'] = array();
        }
        $s = $this->symptome->get($matricule);
        if (in_array(serialize($s), $_SESSION['symptomes']))
            $_SESSION['symptomes'] = $this->deleteArray($_SESSION['symptomes'], serialize($s));
        $symp = $this->symptome->find("");
        $this->set(array("symptome" => $symp, "symptomepatient" => $this->unserializableArray($_SESSION['symptomes'])));
        $this->render("symptome");
    }

    function maladie() {
        $maladies = $this->maladie->findMaladieWithSymptome($this->unserializableArray($_SESSION['symptomes']));
        $this->set(array("maladies" => $maladies));
        $this->render("maladie");
    }

    function traitement($matricule) {
        $_SESSION['maladie'] = $matricule;
        $med = $this->procedure->getMedicamentsFromMaladie($matricule);
        $medicaments =array();
        foreach($med["CODECIS"] as $d){
            array_push($medicaments, $this->medicament->get($d));
        }
        //$medicaments= $this->medicament->getMedicamentWithMaladie($matricule);
        $file = fopen(ROOT . 'templates/entete.html.twig', 'r+');
        $clean_html = fgets($file);
        fclose($file);
        $this->set(array("medicaments" => $medicaments, "medecin" => unserialize($_SESSION['user']),
        "medecin" => unserialize($_SESSION['user']),
        "patient" => unserialize($_SESSION['patient']),
        "entete" => $clean_html));
        $this->enregistrementConsultation();
        $this->render("traitement");
    }

    function enregistrementConsultation() {
        $id_c = $this->consultation->insert(new ConsultationEntity(null,
                        unserialize($_SESSION['user'])->getMatricule(),
                        unserialize($_SESSION['patient'])->getMatricule(),
                        date('d/m/Y')));
        $_SESSION['symptomes'] = $this->unserializableArray($_SESSION['symptomes']);
        foreach ($_SESSION['symptomes'] as $data) {
            $this->symptome->insertIntoSymptome_Consultation($id_c, $data->getCode());
        }
    }

    private function unserializableArray($arr) {
        $d = array();
        foreach ($arr as $data) {
            array_push($d, unserialize($data));
        }
        return $d;
    }

    private function deleteArray($array, $value) {
        $temp = array();
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] != $value) {
                array_push($temp, $array[$i]);
            }
        }
        return $temp;
    }

}

?>
