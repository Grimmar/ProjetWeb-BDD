<?php

class Deconnexion extends Controller {

    public function index() {
        session_destroy();
        $this->forward("login");
    }

}

?>
