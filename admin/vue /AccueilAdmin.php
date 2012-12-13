<?php
	include_once("../Model/Entite/Medecin.php");
	session_start();
	echo "Admin";
	$m = unserialize($_SESSION['user']);
	echo "<h1>".$m->getLogin()."</h1>"
	//echo "<h1>".$_SESSION['user']."</h1>"
?>