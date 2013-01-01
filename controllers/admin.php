<?php

class admin extends Controller {

    protected $models = array("medecin");

    public function __construct() {
        parent::__construct();
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
