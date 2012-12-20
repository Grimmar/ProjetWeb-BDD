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
require_once(ROOT."models/Entite/Medicament.php");

class DAOMedicament extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Medicaments WHERE codeCIS = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Medicaments WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Medicaments", array('codeCIS', 'libelleMedicament'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Medicaments WHERE codeCIS = :id');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $medicament = new Medicament($donnee['codeCIS'], $donnee['libelleMedicament']);
            return $medicament;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Medicaments (codeCIS, libelleMedicament) VALUES 
			(:codeCIS, :libelleMedicament');

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
