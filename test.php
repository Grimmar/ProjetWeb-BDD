<?php
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates/');
$twig = new Twig_Environment($loader, array(
    'cache' => false
));

$template = $twig->loadTemplate('admin.html');
echo $template->render(array(
    'moteur_name' => 'Twig'
)); 
//Load a template
//$template = $twig->loadTemplate('index.html');

//render it
//echo $template->render(array('the' => 'variables', 'go' => 'here'));
?>
