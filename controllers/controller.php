<?php

/**
 * Description of controler
 *
 * @author bissoqu1
 */
class Controller {

    private $twig;
    private $vars;
    private $messages;

    public function __construct() {
        session_start();
        $this->vars = array();
        $this->vars['WEBROOT'] = WEBROOT;
        $this->messages = array();

        $loader = new Twig_Loader_Filesystem(ROOT . 'views/');
        $this->twig = new Twig_Environment($loader, array(
                    'cache' => false
                ));

        if (isset($_POST)) {
            $this->data = $_POST;
        }
        try {
            if (isset($this->models)) {
                foreach ($this->models as $m) {
                    $this->loadModel($m);
                }
            }
        } catch (Exception $e) {
            if(isset($_SESSION['user']))
                $this->forward("configurationBDD");
        }
    }

    function addMessage($message) {
        array_push($this->messages, $message);
    }

    function getMessages() {
        return $this->messages;
    }

    protected function set($d) {
        $this->vars = array_merge($this->vars, $d);
    }

    protected function render($filename) {
        $template = $this->twig->loadTemplate(get_class($this) . '/'
                . strtolower($filename) . '.html.twig');
        echo $template->render($this->vars);
    }

    protected function loadModel($name) {
        $cons = ucfirst(strtolower($name)) . 'Dao';
        require_once(ROOT . 'models/DAO/' . $cons . '.php');
        $this->$name = new $cons();
    }

    function error($code, $message) {
        $this->set(array('code' => $code, 'message' => $message));
        header("HTTP/1.0 ", $code);
        $template = $this->twig->loadTemplate('error/error.html.twig');
        echo $template->render($this->vars);
    }

    function forward($url) {
        header('Location: ' . WEBROOT . $url);
    }

    //Eviter les injections SQL
    protected function secure_input($string) {
        // On regarde si le type de string est un nombre entier (int)
        if (ctype_digit($string)) {
            $string = intval($string);
        } else {
            $string = mysql_real_escape_string($string);
            $string = addcslashes($string, '%_');
        }

        return $string;
    }

    //Se protéger contre les injections html
    protected function html($string) {
        return htmlentities($string);
    }

}

?>
