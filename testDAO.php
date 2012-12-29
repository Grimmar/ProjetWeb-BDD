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

require_once("./models/Entite/Caracteristique.php");
require_once("./models/Entite/Classe_Chimiques.php");
require_once("./models/Entite/Classe_Pharmacologiques.php");
require_once("./models/Entite/Consultation.php");
require_once("./models/Entite/Effet_Indesirable_FR.php");
require_once("./models/Entite/Effet_Indesirable_OMS.php");
require_once("./models/Entite/Laboratoire.php");
require_once("./models/Entite/Maladie.php");
require_once("./models/Entite/Maladie_Chronique.php");
require_once("./models/Entite/Medecin.php");
require_once("./models/Entite/Medicament.php");
require_once("./models/Entite/Patient.php");
require_once("./models/Entite/Substance_Actives_FR.php");
require_once("./models/Entite/Substance_Actives_OMS.php");
require_once("./models/Entite/Symptome.php");
require_once("./models/Entite/Traitement.php");
require_once("./models/Entite/Adresse_Type.php");

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
    "Caracteristique" => new DAOCaracteristique(),
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
    "Substance active fr" => new DAOSubstance_Actives_FR(),
    "Substance active OMS" => new DAOSubstance_Actives_OMS(),
    "Symptome" => new DAOSymptome(),
    "Traitement" => new DAOTraitement()
);

$insert = array(
    "Caracteristique" => new Caracteristique("0", "test"),
    "Classe chimique" => new Classe_Chimiques("0", "test", null),
    "Classe pharmacologique" => new Classe_Pharmacologiques("0","test",null),
    "Consultation" => new Consultation("0","0","0","0","0"),
    "Effet indesirable fr" => new Effet_Indesirable_FR("0","test", null),
    "Effet indesirable oms" => new Effet_Indesirable_OMS("0", "test", null),
    "Laboratoire" => new Laboratoire("0","test"),
    "Maladie" => new Maladie("0","0",null, "test"),
    "Maladie chronique" => new Maladie_Chronique("0", "test"),
    "Medecin" => new Medecin("test","test","medecin","0", null,null,null, null, null, new Addresse_Type("0","test","test","test") ),
    "Patient" => new Patient("0", null, null, null, null, null, new Addresse_Type("1","test","test","test")),
    "Substance active fr" => new Substance_Actives_FR("0","test","test"),
    "Substance active OMS" => new Substance_Actives_OMS("0","test","test"),
    "Symptome" => new Symptome("0", "test"),
    "Traitement" => new Traitement("0", "0", "1"));



foreach ($obj as $key => $val) {
    echo "<h1>" . $key . "</h1>";
    try {
		echo "<h2>INSERT</h2>";
			$v = $val->insert($insert[$key]);
			echo "INSERT OK : ".$v;
		echo "<h2>GET</h2>";
			 $v = $val->get(0);
			echo "GET OK : ".var_dump($v);
		echo "<h2>UPDATE</h2>";
			$val->update($insert[$key]);
			echo "UPDATE OK : ";
		echo "<h2>DELETE</h2>";
			 //$v = $val->delete(0);
			echo "DELETE OK : ";
		echo "<h2>FIND</h2>";
			 $v = $val->find(NULL);
			echo "FIND OK : ";
    } catch (Exception $e) {
        echo "<div style='color :red;'>";
        echo "<h3>DAOManager Erreur dans le getInstance</h3>";
        echo $e->getMessage() . "</div>";
    }
}

?>
