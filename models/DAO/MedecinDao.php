<?php

require_once ("AbstractDao.php");
require_once(ROOT . "models/Entite/MedecinEntity.php");
require_once(ROOT . "models/Entite/AdresseTypeEntity.php");

class MedecinDao extends AbstractDao {

    public function get($id) {
        $sql = "SELECT login, motdepasse, role, matricule, 
            nom, prenom, telephone, numeroSecu, dateNaissance,
            m.adresse.numero \"numero\", m.adresse.adresse \"adresse\",
            m.adresse.ville \"ville\", m.adresse.codepostal \"codePostal\" 
            FROM Medecins m WHERE matricule = :id ";

        $statement = $this->bdd->prepare($sql);
        $statement->execute(array(":id" => $id));
        $d = $statement->fetchAll(PDO::FETCH_OBJ);
        if (count($d) != 1) {
            echo "ici !";
            return null;
        }
        return new MedecinEntity($d[0]->login, $d[0]->motdepasse,
                        $d[0]->role, $d[0]->matricule, $d[0]->nom,
                        $d[0]->prenom, $d[0]->telephone,
                        $d[0]->numerosecu, $d[0]->datenaissance,
                        new AdresseTypeEntity($d[0]->numero,
                                $d[0]->adresse, $d[0]->ville,
                                $d[0]->codepostal));
    }

    public function find($a = null) {
        $sql = "SELECT login, motdepasse, role, matricule, 
            nom, prenom, telephone, numeroSecu, dateNaissance,
            m.adresse.numero \"numero\", m.adresse.adresse \"adresse\",
            m.adresse.ville \"ville\", m.adresse.codepostal \"codePostal\" 
            FROM Medecins m ";

        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        if (!$statement->execute()) {
            return null;
        }
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result = array();
        foreach ($statement as $d) {
            $adress = new AdresseTypeEntity($d->numero, $d->adresse,
                            $d->ville, $d->codepostal);
            $m = new MedecinEntity($d->login,
                            $d->motdepasse, $d->role, $d->matricule,
                            $d->nom, $d->prenom, $d->telephone,
                            $d->numerosecu, $d->datenaissance, $adress);
            array_push($result, $m);
            unset($adress);
            unset($m);
        }
        return $result;
    }

    function count($a = null) {
        $sql = "SELECT COUNT(*) FROM Medecins ";
        if ($a != null && is_array($a)) {
            $sql .= $this->getWhereArray($a);
        }
        $statement = $this->bdd->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();;
    }

    public function insert($entity) {
        $statement = $this->bdd->prepare('INSERT INTO Medecins(login, motDePasse,
            role, nom, prenom, telephone, numeroSecu, dateNaissance, adresse) 
            VALUES(:login, :motDePasse, :role, :nom, :prenom, :telephone,
            :numeroSecu, to_date(:dateNaissance, \'DD/MM/YYYY\'),
            Adresse_Type(:numero, :adresse, :ville, :codePostal))');

        $statement->execute(array(
            'login' => $entity->getLogin(),
            'motDePasse' => $entity->getMotDePasse(),
            'role' => "MEDECIN",
            'nom' => $entity->getNom(),
            'prenom' => $entity->getPrenom(),
            'telephone' => $entity->getTelephone(),
            'numeroSecu' => $entity->getNumeroSecu(),
            'dateNaissance' => $entity->getDateNaissance(),
            'numero' => $entity->getAdresse()->getNumero(),
            'adresse' => $entity->getAdresse()->getAdresse(),
            'ville' => $entity->getAdresse()->getVille(),
            'codePostal' => $entity->getAdresse()->getCodePostal()
        ));
    }

    //Update
    public function update($entity) {
        $statement = $this->bdd->prepare('UPDATE Medecins m SET login = :login,
            motDePasse = :motDePasse, nom = :nom, prenom = :prenom,
            telephone = :telephone, numeroSecu = :numeroSecu,
            dateNaissance = to_date(:dateNaissance, \'DD/MM/YYYY\'),
            m.Adresse.numero = :numero, 
            m.Adresse.adresse = :adresse, m.Adresse.ville = :ville,
            m.Adresse.codePostal = :codePostal WHERE matricule = :matricule');
        $count = $statement->execute(array(
            'login' => $entity->getLogin(),
            'motDePasse' => $entity->getMotDePasse(),
            'matricule' => $entity->getMatricule(),
            'nom' => $entity->getNom(),
            'prenom' => $entity->getPrenom(),
            'telephone' => $entity->getTelephone(),
            'numeroSecu' => $entity->getNumeroSecu(),
            'dateNaissance' => $entity->getDateNaissance(),
            'numero' => $entity->getAdresse()->getNumero(),
            'adresse' => $entity->getAdresse()->getAdresse(),
            'ville' => $entity->getAdresse()->getVille(),
            'codePostal' => $entity->getAdresse()->getCodePostal()
                ));
        return $count;
    }

    //Delete
    public function delete($id) {
        $statement = $this->bdd->prepare("DELETE FROM Medecins WHERE matricule = :id");
        $count = $statement->execute(array("id" => $id));
        return $count;
    }

}

?>
