<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOSymptome
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/Symptome.php");

class DAOSymptome extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Symptomes WHERE code = :code");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Symptomes WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Symptome", array('code', 'libelle'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Symptomes WHERE code = :code');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $carac = new Symptome($donnee['code'], $donnee['libelle']);
            return $carac;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Symptomes (code, libelle) VALUES 
			(:code, :libelle');
        $req->execute(array(
            'code' => $entity->getCode(),
            'libelle' => $entity->getLibelle()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Symptomes SET libelle = :libelle  WHERE code = :code');
        $count = $req->execute(array(
            'code' => $entity->getCode(),
            'libelle' => $entity->getLibelle()
                ));
        return $count;
    }

}

?>
