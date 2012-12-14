<?php
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates/');
$twig = new Twig_Environment($loader, array(
    'cache' => false
));

$template = $twig->loadTemplate('ajoutPatient.html');
echo $template->render(array(
    'moteur_name' => 'Twig'
));
?>
