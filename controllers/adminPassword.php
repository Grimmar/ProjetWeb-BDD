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
class adminPassword extends Controller {

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

    public function updateProcess() {
        $document_xml = new DomDocument();
        $document_xml->load($this->fichier);
        $password = $document_xml->getElementsByTagName('password');
        $password->item(0)->nodeValue = $_POST['md5'];
        $data = array("password" => $password->item(0)->nodeValue);
        $this->set($data);
        $document_xml->save(ROOT . "models/config.xml");
        $this->render('index');
    }
}

?>
