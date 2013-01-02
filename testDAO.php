<?php

define('ROOT', str_replace('testDAO.php', '', $_SERVER['SCRIPT_FILENAME']));
require_once("./models/DAO/ManagerDao.php");
require_once("./models/DAO/CaracteristiqueDao.php");
require_once("./models/DAO/ClasseChimiqueDao.php");
require_once("./models/DAO/ClassePharmacologiqueDao.php");
require_once("./models/DAO/ConsultationDao.php");
require_once("./models/DAO/EffetIndesirableFRDao.php");
require_once("./models/DAO/EffetIndesirableOMSDao.php");
require_once("./models/DAO/LaboratoireDao.php");
require_once("./models/DAO/Maladie.php");
require_once("./models/DAO/MaladieChroniqueDao.php");
require_once("./models/DAO/MedecinDao.php");
require_once("./models/DAO/MedicamentDao.php");
require_once("./models/DAO/PatientDao.php");
require_once("./models/DAO/SubstanceActiveFRDao.php");
require_once("./models/DAO/SubstanceActiveOMSDao.php");
require_once("./models/DAO/SymptomeDao.php");
require_once("./models/DAO/TraitementDao.php");

require_once("./models/Entite/CaracteristiqueEntity.php");
require_once("./models/Entite/ClasseChimiqueEntity.php");
require_once("./models/Entite/ClassePharmacologiqueEntity.php");
require_once("./models/Entite/ConsultationEntity.php");
require_once("./models/Entite/EffetIndesirableFREntity.php");
require_once("./models/Entite/EffetIndesirableOMSEntity.php");
require_once("./models/Entite/LaboratoireEntity.php");
require_once("./models/Entite/MaladieEntity.php");
require_once("./models/Entite/MaladieChroniqueEntity.php");
require_once("./models/Entite/MedecinEntity.php");
require_once("./models/Entite/MedicamentEntity.php");
require_once("./models/Entite/PatientEntity.php");
require_once("./models/Entite/SubstanceActiveFREntity.php");
require_once("./models/Entite/SubstanceActiveOMSEntity.php");
require_once("./models/Entite/SymptomeEntity.php");
require_once("./models/Entite/TraitementEntity.php");
require_once("./models/Entite/AdresseTypeEntity.php");

echo "<h1>Page de test des DAO</h1>";

echo "<h2>Connexion</h2>";
$dao = null;
try {
    $dao = DaoManager::getInstance();
    echo "<br/> Connexion ok !<br/> ";
} catch (Exception $e) {
    echo "<div style='color :red;'>";
    echo "<h3>DAOManager Erreur dans le getInstance</h3>";
    echo $e->getMessage() . "</div>";
}


$obj = array(
    /*"Caracteristique" => new CaracteristiqueDao(),
    "Classe chimique" => new ClasseChimiqueDao(),
    "Classe pharmacologique" => new ClassePharmacologiqueDao(),
    "Consultation" => new ConsultationDao(),
    "Effet indesirable fr" => new EffetIndesirableFRDao(),
    "Effet indesirable oms" => new EffetIndesirableOMSDao(),
    "Laboratoire" => new LaboratoireDao(),
    "Maladie" => new MaladieDao(),
    "Maladie chronique" => new MaladieChroniqueDao(),
    "Medecin" => new MedecinDao(),
    "Patient" => new PatientDao(),
    "Medicament" => new Medicament()Dao,*/
    "Substance active fr" => new SubstanceActiveFRDao(),
    "Substance active OMS" => new SubstanceActiveOMSDao()
    /*"Symptome" => new SymptomeDao(),
    "Traitement" => new TraitementDao()*/
);

$insert = array(
    /*"Caracteristique" => new CaracteristiqueEntity(0, "test"),
    "Classe chimique" => new ClasseChimiqueEntity(0, "test", null),
    "Classe pharmacologique" => new ClassePharmacologiqueEntity(0, "test", null),
    "Consultation" => new ConsultationEntity("1", "0", "0", "12/12/12"),
    "Effet indesirable fr" => new EffetIndesirableFREntity("0", "test", null),
    "Effet indesirable oms" => new EffetIndesirableOMSEntity("0", "test", null),
    "Laboratoire" => new LaboratoireEntity("0", "test"),
    "Maladie" => new MaladieEntity("0", "0", null, "test"),
    "Maladie chronique" => new MaladieChroniqueEntity("0", "test"),
    "Medecin" => new MedecinEntity("test", "test", "medecin", 0, "test", "test", 32131, 45456454, "12/12/12", new Adresse_TypeEntity(0, "test", "test", 2300)),
    "Patient" => new PatientEntity(0, "test", "test", 32131, 45456454, "12/12/12", new Adresse_TypeEntity(0, "test", "test", 2300)),
    "Medicament" => new MedicamentEntity("0", "test"),*/
    "Substance active fr" => new SubstanceActiveFREntity("2", "test", new ClassePharmacologiqueEntity(1, "pouet", null)),
    "Substance active OMS" => new SubstanceActiveOMSEntity("2", "test", new ClassePharmacologiqueEntity(1, "pouet", null))
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
        echo "<h3>DaoManager Erreur dans le getInstance</h3>";
        echo $e->getMessage() . "</div>";
    }
}
?>
