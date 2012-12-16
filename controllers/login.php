<?php

/**
 * Description of login
 *
 * @author bissoqu1
 */
class login extends Controller {
      
    //private $models = array(nom du dao);
    
    function index() {
        //TODO isConnected
        if (true) {
            $this->render('index');
        } else {
            $this->forward('accueil');
        }
    }
    
    function process() {
   
    }
    
}

?>
