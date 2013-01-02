<?php

/**
 * Description of IdentifiedController
 *
 * @author Quentin
 */
class IdentifiedController extends Controller {

    protected $user = null;

    public function __construct() {
        parent::__construct();
        if (isset($_SESSION['user'])) {
            $this->user = unserialize($_SESSION['user']);
            $this->set(array("user" => $this->user));
        } else {
            $this->forward("login");
        }
    }

}

?>
