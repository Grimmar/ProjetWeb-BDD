<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminPassword
 *
 * @author David
 */
require_once(ROOT . 'controllers\administrationController.php');
require_once(ROOT . 'models\DAO\DaoManager.php');

class adminPassword extends AdministrationController {

    private $fichier;

    public function __construct() {
        parent::__construct();
        $this->fichier = ROOT . "models/admin.xml";
    }

    public function index() {
        $document_xml = new DomDocument();
        $document_xml->load($this->fichier);
        $password = $document_xml->getElementsByTagName('password');
        $data = array("password" => $password->item(0)->nodeValue);
        $this->set($data);
        $this->render('index');
    }

    public function updateProccess() {
        if ($_POST['md5'] == $_POST['md5Confirm']) {
            $document_xml = new DomDocument();
            $document_xml->load($this->fichier);
            $password = $document_xml->getElementsByTagName('password');
            $password->item(0)->nodeValue = $_POST['md5'];
            $data = array("password" => $password->item(0)->nodeValue, "ok"=>"Mot de passe modifié");
            $this->set($data);
            $document_xml->save(ROOT . "models/admin.xml");
            $this->render('index');
        } else {
            $this->set(array("erreur"=>"Les mots de passe sont differents"));
            $this->render('index');
        }
    }

}

?>
