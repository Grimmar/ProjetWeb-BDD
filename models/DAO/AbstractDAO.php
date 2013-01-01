<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractDAO
 *
 * @author david
 */
//define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
abstract class AbstractDAO implements DAO {

    protected $dao;
    protected $bdd;

    public function __construct() {
        $this->dao = DAOManager::getInstance();
        $this->bdd = $this->dao->getConnexion();
    }

    protected function getWhereArray($whereArray) {
        $where = "";
        $finReq = "";
        $last_key = end(array_keys($whereArray));
        $first_key = TRUE;
       
        foreach ($whereArray as $key => $value) {
            if (strpos($key, "order") !== FALSE || strpos($key, "LIMIT") !== FALSE) {
                $finReq .= $key . " " . $value . " ";
            } else {
                if ($last_key == $key) {
                    $where .= $key . "'" . $value . "'";
                } else if ($first_key) {
                    $where .= " where ".$key . "'" . $value . "'";
                    $first_key = FALSE;
                }{
                    $where .= $key . "'" . $value . "' and ";
                }
            }
        }
        $where .= $finReq;
        return $where;
    }

}

?>
