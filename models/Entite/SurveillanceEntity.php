<?php

/**
 * Description of SurveillanceEntity
 *
 * @author Quentin
 */
class SurveillanceEntity {
    private $identifiant;
    private $medecin;  
    private $nombreMedicamentDeveloppe;
    private $nombreLabTravaille;
    private $nombreMedicamentPrescrit;
    private $rapport;
    
    public function __construct($id, $med, $nbMD, $nbLT, $nbMP, $rap) {
        $this->identifiant = $id;
        $this->medecin = $med;
        $this->nombreMedicamentDeveloppe = $nbMD;
        $this->nombreLabTravaille = $nbLT;
        $this->nombreMedicamentPrescrit = $nbMP;
        $this->rapport = $rap;
    }
    
    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function getMedecin() {
        return $this->medecin;
    }

    public function getNombreMedicamentDeveloppe() {
        return $this->nombreMedicamentDeveloppe;
    }

    public function getNombreLabTravaille() {
        return $this->nombreLabTravaille;
    }

    public function getNombreMedicamentPrescrit() {
        return $this->nombreMedicamentPrescrit;
    }

    public function getRapport() {
        return $this->rapport;
    }


}

?>
