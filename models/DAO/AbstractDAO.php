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
        foreach ($whereArray as $key => $value) {
            if (strpos($key, "order") !== FALSE || strpos($key, "LIMIT") !== FALSE) {
                $finReq .= $key . " " . $value . " ";
            } else {
                $where .= $key . " " . $value . " and";
            }
        }
        $where .= $finReq;
        return $where;
    }

}

?>
