<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOMaladie
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/Maladie.php");

class DAOMaladie extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Maladies WHERE idMaladie = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Maladies WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Maladie", array('idMaladie', 'codeArborescence', 'idPere', 'libelle'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Maladies WHERE idMaladie = :id');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $maladie = new Maladie($donnee['idMaladie'], $donnee['codeArborescence'], $donnee['idPere'],
                            $donnee['libelle']);
            return $maladie;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Maladies (idMaladie, codeArborescence, idPere, libelle) values
			:idMaladie, :codeArborescence, :idPere, :libelle');

        $req->execute(array(
            'idMaladie' => $entity->getIdMaladie(),
            'codeArborescence' => $entity->getCodeArborescence(),
            'idPere' => $entity->getIdPere(),
            'idMaladie' => $entity->getIdMaladie(),
            'libelle' => $entity->getLibelle()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Maladies SET codeArborescence = :codeArborescence, idPere = :idPere,
            libelle = :libelle WHERE idMaladie = :idMaladie');
        $count = $req->execute(array(
            'idMaladie' => $entity->getIdMaladie(),
            'codeArborescence' => $entity->getCodeArborescence(),
            'idPere' => $entity->getIdPere(),
            'idMaladie' => $entity->getIdMaladie(),
            'libelle' => $entity->getLibelle()
                ));
        return $count;
    }

}

?>
