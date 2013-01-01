<?php

/**
 * Description of accueil
 *
 * @author bissoqu1
 */
class accueil extends Controller {

    protected $models = array("medecin");

    function index() {
        $this->render('index');
    }

}

?>
