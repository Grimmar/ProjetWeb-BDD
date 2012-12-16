<?php

/**
 * Description of login
 *
 * @author bissoqu1
 */
class login extends Controller {
      
    //private $models = array(nom du dao);
    
    function index() {
        if (isset ($this->data)) {
            $this->set($this->data);
        }
        $this->render('index');
    }
    
}

?>
