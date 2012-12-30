<?php

class admin extends Controller{
    
    
    public function __construct() {
        parent::__construct();
        //$this->dao = new DAOMedecin();
        $this->loadModel("medecin");
        session_start();
        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);
            $this->set(array("user" => $user));
        } else {
            $this->forward("login");
        }
    }

    function index() {
       $this->render('index');
    }
}
?>
