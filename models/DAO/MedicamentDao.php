<?php

/**
 * Description of DAOMedicament
 *
 * @author david
 */
require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/MedicamentEntity.php");

class MedicamentDao extends AbstractDao {

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Medicaments ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Medicaments 
            WHERE codeCIS = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

    public function find($a = null) {
        $sql = "SELECT * FROM Medicaments ";
        if ($a != null && is_array($a)) {
            $sql .=$this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new MedicamentEntity($d->codecis, $d->libelle));
        }
        return $result;
    }

    public function get($id) {
        $statement = $this->bdd->prepare('SELECT * FROM Medicaments 
            WHERE codeCis = :code');
        $statement->execute(array("code" => $id));
        $d = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            return null;
        }
        return new MedicamentEntity($d[0]->codecis, $d[0]->libelle);
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Medicaments (codeCIS, 
            libelle) VALUES 
			(:codeCIS, :libelle)');

        $statement->execute(array(
            'codeCIS' => $entity->getCodeCIS(),
            'libelle' => $entity->getLibelle()));
    }

    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Medicaments SET libelle = :libelle
            WHERE codeCIS = :codeCIS');
        $count = $statement->execute(array(
            'codeCIS' => $entity->getCodeCIS(),
            'libelle' => $entity->getLibelle()));
        return $count;
    }

    public function getMedicamentWithMaladie($idMaladie) {
        $sql = "SELECT m.* FROM Medicaments m, Maladie_medicament mm where m.codecis=mm.codecis and mm.idmaladie = :idmaladie";
        //echo $sql;
        $statement = $this->bdd->prepare($sql);
        $statement->execute(array("idmaladie" => $idMaladie));
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            array_push($result, new MedicamentEntity($d->codecis, $d->libelle));
        }
        return $result;
        /* $query = "select MEDICAMENTS_FROM_MALADIE(:idMaladie) m from dual";

          var_dump($this->dao->getOracleConnexion());
          $stmt = OCIParse($this->dao->getOracleConnexion(), $query) or die('Can not parse query');
          OCIBindByName($stmt, ":idMaladie", $idMaladie, 20) or die('Can not bind variable');

          $gid = 1; // for gid =1 or 2
          OCIExecute($stmt) or die('Can not Execute statment');
          var_dump(ocifetch($stmt));
          /*while (ocifetch($stmt)) {
          echo '<br>' . $con . " <" . ociresult($stmt, "MCOUNT") . ">\n\n";
          $_friends = ociresult($stmt, "MCOUNT");
          echo '<br>' . $con . "----done\n\n";
          } */
    }

}

?>
