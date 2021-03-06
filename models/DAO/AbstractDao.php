
<?php

/**
 * Description of AbstractDAO
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");

abstract class AbstractDao implements Dao {

    protected $dao;
    protected $bdd;

    public function __construct() {
        $this->dao = DaoManager::getInstance();
        $this->bdd = $this->dao->getConnexion();
    }

    protected function getWhereArray($whereArray) {
        $where = "";
        $finReq = "";
        $last_key = end(array_keys($whereArray));
        $first_key = TRUE;

        foreach ($whereArray as $key => $value) {
            if (strpos($key, "order") !== FALSE || strpos($key, "limit") !== FALSE) {
                $finReq .= $key . " " . $value . " ";
            } else {
                if ($first_key === TRUE) {
                    $where .= " where ";
                    $first_key = FALSE;
                }
                if (is_numeric($value)) {
                    $where .= $key . $value;
                } else {
                    $where .= $key . "'" . $value . "'";
                }
                if ($last_key != $key) {
                    $where .= " and ";
                }
            }
        }
        $where .= $finReq;
        return $where;
    }

}

?>