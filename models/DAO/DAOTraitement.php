<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOTraitement
 *
 * @author david
 */
require_once("DAO.php");
require_once("DAOManager.php");
require_once("../Entite/Traitement.php");

class DAOTraitement extends AbstractDAO {

    public function count($entity) {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Traitement WHERE identifiant = :id");
        $count = $req->execute(array("id" => $id));
        return $count;
    }

    public function find($a) {
        if (!is_array($a)) {
            return null;
        }
        $req = $this->bdd->prepare('SELECT * FROM Traitements WHERE :where');
        $where = getWhereArray($a);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Traitement", array('identifiant', 'idMaladie', 'matriculeMedecin', 'matriculePatient'
            , 'recommendations'));
        $donnee = $req->execute(array("where" => $where));
        return $donnee;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Traitements WHERE identifiant = :id');
        $req->execute(array("id" => $id));
        if ($req->rowCount() != 1) {
            //TODO: A TEST !
            return null;
        } else {
            $donnee = $req->fetch();
            $traitement = new Consultation($donnee['identifiant'], $donnee['idMaladie'], $donnee['matriculeMedecin'], $donnee['matriculePatient'],
                            $donnee['recommendations']);
            return $traitement;
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Traitements (identifiant, idMaladie, matriculeMedecin, matriculePatient, recommendations) 
			:identifiant, :idMaladie, :matriculeMedecin, :matriculePatient, recommendations(:code, :libelle) ');

        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'matriculeMedecin' => $entity->getMatriculeMedecin(),
            'matriculePatient' => $entity->getMatriculePatient(),
            'idMaladie' => $entity->getIdMaladie(),
            'code' => $entity->getRecommendations().getCode(),
            'libelle' => $entity->getRecommendations().getLibelle()
        ));
        
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Traitements t SET idMalade = :idMaladie, matriculeMedecin = :matriculeMedecin, matriculePatient = :matriculePatient,
             t.recommendations.code = :code, t.recommandations.libelle = :libelle
        and WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'matriculeMedecin' => $entity->getMatriculeMedecin(),
            'matriculePatient' => $entity->getMatriculePatient(),
            'idMaladie' => $entity->getIdMaladie(),
            'code' => $entity->getRecommendations().getCode(),
            'libelle' => $entity->getRecommendations().getLibelle()
        ));
        return $count;
    }

}

?>
