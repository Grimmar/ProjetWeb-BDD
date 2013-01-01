<?php

/**
 * Description of DAOEffet_Indesirable_FR
 *
 * @author david
 */

require_once ("AbstractDAO.php");
require_once(ROOT."models/Entite/Effet_Indesirable_FREntity.php");

class DAOEffet_Indesirable_FR extends AbstractDAO{
    
     public function count() {
        
    }

    public function delete($id) {
        $req = $this->bdd->prepare("DELETE FROM Effets_Indesirables_FR WHERE identifiant = :identifiant");
        $count = $req->execute(array("identifiant" => $id));
        return $count;
    }

    public function find($a) {
        $sqlrequest = "SELECT * FROM Effets_Indesirables_FR ";
       if ($a != null) {
            if (is_array($a)) {
                $sqlrequest .=$this->getWhereArray($a);
            } else {
                return null;
            }
        }
       $req = $this->bdd->prepare($sqlrequest);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($req as $data){
            array_push($result, new Effet_Indesirable_FREntity($data->IDENTIFIANT, $data->LIBELLE, $data->IDPERE));
        }
        return $result;
    }

    public function get($id) {
        $req = $this->bdd->prepare('SELECT * FROM Effets_Indesirables_FR WHERE identifiant = :identifiant');
        $req->execute(array("identifiant" => $id));
         $donnee = $req->FetchAll(PDO::FETCH_OBJ);
        if (count($donnee) != 1) {
            return null;
        } else {
            return new Effet_Indesirable_FREntity($donnee[0]->IDENTIFIANT, $donnee[0]->LIBELLE, $donnee[0]->IDPERE);
        }
    }

    public function insert($entity) {
        $req = $this->bdd->prepare('INSERT INTO Effets_Indesirables_FR (identifiant, libelle, idPere) VALUES 
			(:identifiant, :libelle, :idPere)');
        $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()
        ));
    }

    public function update($entity) {
        $req = $this->bdd->prepare('UPDATE Effets_Indesirables_FR SET libelle = :libelle, idPere = :idPere  WHERE identifiant = :identifiant');
        $count = $req->execute(array(
            'identifiant' => $entity->getIdentifiant(),
            'libelle' => $entity->getLibelle(),
            'idPere' => $entity->getIdPere()
                ));
        return $count;
    }

}

?>
