<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class deconnexion extends Controller {

    public function index() {
        session_start();
        session_destroy();
        $this->forward("login");
    }

}

?>
