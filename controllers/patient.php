<?php

class patient extends PersonneController {

    function index() {
        $this->render('index');
    }

    function view($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $d = array('matricule' => $matricule);
            $this->set($d);
            $this->render('view');
        }
    }

    function add() {
        $this->render('update');
    }

    function update($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $d = array('matricule' => $matricule);
            $this->set($d);
            $this->render('update');
        }
    }

    function delete($matricule = null) {
        if (!isset($matricule) || !is_numeric($matricule)) {
            $this->index();
        } else {
            $d = array('matricule' => $matricule);
            $this->set($d);
            $this->render('delete');
        }
    }

}

?>
