<?php

/**
 * Description of entete
 *
 * @author Quentin
 */
require_once(ROOT . 'controllers\administrationController.php');
require_once(ROOT . 'lib\HtmlPurifier\library\HTMLPurifier.auto.php');

class Entete extends AdministrationController {

    protected $models = array("medecin");

    public function __construct() {
        parent::__construct();
        $config = HTMLPurifier_Config::createDefault();
        $this->purifier = new HTMLPurifier($config);
    }

    function index() {
        $file = fopen(ROOT . 'templates/entete.html.twig', 'r+');
        $clean_html = fgets($file);
        fclose($file);
        $this->set(array("entete" => $clean_html));
        $this->render('index');
    }

    function process() {
        $clean_html = $this->purifier->purify($this->data['entete']);
        $file = fopen(ROOT . 'templates/entete.html.twig', 'w+');
        fputs($file, $clean_html);
        fclose($file);
        $this->forward('entete');
    }

}

?>
