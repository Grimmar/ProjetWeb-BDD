<?php
/**
 * Description of accueil
 *
 * @author bissoqu1
 */
session_start();
class accueil extends Controller {
    
    function index() {
        $this->render('index');
    }
}

?>
