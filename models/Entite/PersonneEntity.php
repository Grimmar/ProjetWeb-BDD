<?php

abstract class PersonneEntity {

    private $matricule;
    private $nom;
    private $prenom;
    private $telephone;
    private $numeroSecu;
    private $dateNaissance;
    private $adresse;

    function __construct($matricule, $nom, $prenom, $telephone, $numeroSecu, $dateNaissance, $adresse) {
        $this->matricule = $matricule;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->numeroSecu = $numeroSecu;
        $this->dateNaissance = $dateNaissance;
        $this->adresse = $adresse;
    }

        /* public function __call($name, $argument){
      $get = strtolower(substr($name,3,strlen($name)));
      return $this->$get;
      } */
    public function getMatricule() {
        return $this->matricule;
    }

    public function setMatricule($matricule) {
        $this->matricule = $matricule;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function getNumeroSecu() {
        return $this->numeroSecu;
    }

    public function setNumeroSecu($numeroSecu) {
        $this->numeroSecu = $numeroSecu;
    }

    public function getDateNaissance() {
        return $this->dateNaissance;
    }

    public function setDateNaissance($dateNaissance) {
        $this->dateNaissance = $dateNaissance;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

}

?>
