<?php

/**
 * Description of controler
 *
 * @author bissoqu1
 */

class Controller {

    private $twig;
    private $vars;
    private $processErrors;
    
    public function __construct() {
        session_start();
        $this->vars = array();
        $this->vars['WEBROOT'] = WEBROOT;
        $this->processErrors = array();
                
        $loader = new Twig_Loader_Filesystem(ROOT.'views/');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => false
        ));
        
        if (isset($_POST)) {
            $this->data = $_POST;
        }
        
        if (isset($this->models)) {
            foreach ($this->models as $m) {
                $this->loadModel($m);
            }
        }
    }
    
    function addProcessError($message) {
        array_push($this->processErrors, $message);
    }
    
    function getProcessErrors() {
        return $this->processErrors;
    }
    
    protected function set($d) {
        $this->vars = array_merge($this->vars, $d);
    }
    
    protected function render($filename) {
        $template = $this->twig->loadTemplate(get_class($this).'/'
                .$filename.'.html');
        echo $template->render($this->vars);
    }
    
    protected function loadModel($name) {
        $cons = 'DAO'. ucfirst(strtolower($name));
        require_once(ROOT.'models/DAO/'. $cons.'.php');
        $this->$name = new $cons();
    }
    
    function error($code, $message) {
        $this->set(array('message' => $message));
        header("HTTP/1.0 ", $code);
        $template = $this->twig->loadTemplate('error/error.html');
        echo $template->render($this->vars);
    }
    
    function forward($url) {
        header('Location: '.WEBROOT.$url);
    }
}

?>
