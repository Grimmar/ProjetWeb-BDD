<?php

define('ROOT', str_replace('testDAO.php', '', $_SERVER['SCRIPT_FILENAME']));
require_once("./models/DAO/DAOManager.php");
require_once("./models/DAO/DAOCaracteristique.php");
require_once("./models/DAO/DAOClasse_Chimique.php");
require_once("./models/DAO/DAOClasse_Pharmacologique.php");
require_once("./models/DAO/DAOConsultation.php");
require_once("./models/DAO/DAOEffet_Indesirable_FR.php");
require_once("./models/DAO/DAOEffet_Indesirable_OMS.php");
require_once("./models/DAO/DAOLaboratoire.php");
require_once("./models/DAO/DAOMaladie.php");
require_once("./models/DAO/DAOMaladie_Chronique.php");
require_once("./models/DAO/DAOMedecin.php");
require_once("./models/DAO/DAOMedicament.php");
require_once("./models/DAO/DAOPatient.php");
require_once("./models/DAO/DAOSubstance_Actives_FR.php");
require_once("./models/DAO/DAOSubstance_Actives_OMS.php");
require_once("./models/DAO/DAOSymptome.php");
require_once("./models/DAO/DAOTraitement.php");

require_once("./models/Entite/CaracteristiqueEntity.php");
require_once("./models/Entite/Classe_ChimiquesEntity.php");
require_once("./models/Entite/Classe_PharmacologiquesEntity.php");
require_once("./models/Entite/ConsultationEntity.php");
require_once("./models/Entite/Effet_Indesirable_FREntity.php");
require_once("./models/Entite/Effet_Indesirable_OMSEntity.php");
require_once("./models/Entite/LaboratoireEntity.php");
require_once("./models/Entite/MaladieEntity.php");
require_once("./models/Entite/Maladie_ChroniqueEntity.php");
require_once("./models/Entite/MedecinEntity.php");
require_once("./models/Entite/MedicamentEntity.php");
require_once("./models/Entite/PatientEntity.php");
require_once("./models/Entite/Substance_Actives_FREntity.php");
require_once("./models/Entite/Substance_Actives_OMSEntity.php");
require_once("./models/Entite/SymptomeEntity.php");
require_once("./models/Entite/TraitementEntity.php");
require_once("./models/Entite/Adresse_TypeEntity.php");

echo "<h1>Page de test des DAO</h1>";

echo "<h2>Connexion</h2>";
$dao = null;
try {
    $dao = DAOManager::getInstance();
    echo "<br/> Connexion ok !<br/> ";
} catch (Exception $e) {
    echo "<div style='color :red;'>";
    echo "<h3>DAOManager Erreur dans le getInstance</h3>";
    echo $e->getMessage() . "</div>";
}


$obj = array(
    /*"Caracteristique" => new DAOCaracteristique(),
    "Classe chimique" => new DAOClasse_Chimique(),
    "Classe pharmacologique" => new DAOClasse_Pharmacologique(),
    "Consultation" => new DAOConsultation(),
    "Effet indesirable fr" => new DAOEffet_Indesirable_FR(),
    "Effet indesirable oms" => new DAOEffet_Indesirable_OMS(),
    "Laboratoire" => new DAOLaboratoire(),
    "Maladie" => new DAOMaladie(),
    "Maladie chronique" => new DAOMaladie_Chronique(),
    "Medecin" => new DAOMedecin(),
    "Patient" => new DAOPatient(),
    "Medicament" => new DAOMedicament(),*/
    "Substance active fr" => new DAOSubstance_Actives_FR(),
    "Substance active OMS" => new DAOSubstance_Actives_OMS()
    /*"Symptome" => new DAOSymptome(),
    "Traitement" => new DAOTraitement()*/
);

$insert = array(
    /*"Caracteristique" => new CaracteristiqueEntity(0, "test"),
    "Classe chimique" => new Classe_ChimiquesEntity(0, "test", null),
    "Classe pharmacologique" => new Classe_PharmacologiquesEntity(0, "test", null),
    "Consultation" => new ConsultationEntity("1", "0", "0", "12/12/12"),
    "Effet indesirable fr" => new Effet_Indesirable_FREntity("0", "test", null),
    "Effet indesirable oms" => new Effet_Indesirable_OMSEntity("0", "test", null),
    "Laboratoire" => new LaboratoireEntity("0", "test"),
    "Maladie" => new MaladieEntity("0", "0", null, "test"),
    "Maladie chronique" => new Maladie_ChroniqueEntity("0", "test"),
    "Medecin" => new MedecinEntity("test", "test", "medecin", 0, "test", "test", 32131, 45456454, "12/12/12", new Addresse_TypeEntity(0, "test", "test", 2300)),
    "Patient" => new PatientEntity(0, "test", "test", 32131, 45456454, "12/12/12", new Addresse_TypeEntity(0, "test", "test", 2300)),
    "Medicament" => new MedicamentEntity("0", "test"),*/
    "Substance active fr" => new Substance_Actives_FREntity("2", "test", new Classe_PharmacologiquesEntity(1, "pouet", null)),
    "Substance active OMS" => new Substance_Actives_OMSEntity("2", "test", new Classe_PharmacologiquesEntity(1, "pouet", null))
    /*"Symptome" => new SymptomeEntity("0", "test"),
    "Traitement" => new TraitementEntity("0", "0", "1")*/
   );



foreach ($obj as $key => $val) {
    echo "<h1>" . $key . "</h1>";
    try {
        echo "<h2>DELETE</h2>";
        //$v = $val->delete(0);
        echo "DELETE OK : ";
        echo "<h2>INSERT</h2>";
        //$val->insert($insert[$key]);
        echo "INSERT OK : ";
        echo "<h2>GET</h2>";
        $v = $val->get(1);
        echo "GET OK : " . var_dump($v);
        echo "<h2>UPDATE</h2>";
        $val->update($insert[$key]);
        echo "UPDATE OK : ";
        echo "<h2>FIND</h2>";
        $v = $val->find(NULL);
        echo "FIND OK : " . var_dump($v);
    } catch (Exception $e) {
        echo "<div style='color :red;'>";
        echo "<h3>DAOManager Erreur dans le getInstance</h3>";
        echo $e->getMessage() . "</div>";
    }
}
?>
