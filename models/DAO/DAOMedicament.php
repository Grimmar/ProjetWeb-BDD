<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOMedicament
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT . "models/Entite/MedicamentEntity.php");

class DAOMedicament extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Medicaments WHERE codeCIS = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        $sqlrequest = "SELECT * FROM Medicaments";
        if ($a != null) {
            if (is_array($a)) {
                $sqlrequest .=" where " . $this->getWhereArray($a);
            } else {
                return null;
            }
        }
        $req = $this->bdd->prepare($sqlrequest);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($req as $data) {
            array_push($result, new MedicamentEntity($data->CODECIS, $data->LIBELLEMEDICAMENT));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Medicaments WHERE CODECIS = :code');
        $req->execute(array("code" => $id));
        $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            return null;
        } else {
            return new MedicamentEntity($donnee[0]->CODECIS, $donnee[0]->LIBELLEMEDICAMENT);
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Medicaments (codeCIS, libelleMedicament) VALUES 
			(:codeCIS, :libelleMedicament)');

        $req->execute(array(
            'codeCIS' => $entity->getCodeCIS(),
            'libelleMedicament' => $entity->getLibelleMedicament()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Medicaments SET libelleMedicament = :libelleMedicament WHERE codeCIS = :codeCIS');
        $count = $req->execute(array(
            'codeCIS' => $entity->getCodeCIS(),
            'libelleMedicament' => $entity->getLibelleMedicament()
                ));
        return $count;
    }

}

?>
