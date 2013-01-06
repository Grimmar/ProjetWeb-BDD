<?php

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
//ini_set("display_errors", 0);
//error_reporting(0);
require(ROOT . 'controllers/controller.php');
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$param = explode('/', $_GET['p']);
if (isset($param[0]) && $param[0] != '') {
    $controller = $param[0];
} else {
    $controller = 'login';
}
if (isset($param[1]) && $param[1] != '') {
    $action = $param[1];
} else {
    $action = 'index';
}

$filename = 'controllers/' . $controller . '.php';
$error = false;
if (file_exists($filename)) {
    require_once($filename);
    $controller = new $controller();
    if (method_exists($controller, $action)) {
        unset($param[0]);
        unset($param[1]);
        try {
            call_user_func_array(array($controller, $action), $param);
        } catch (Exception $e) {
            $error = true;
        }
    } else {
        $error = true;
    }
} else {
    $error = true;
}

if ($error) {
    $controller = new Controller();
    $controller->error(404, 'L\'adresse URL est invalde.');
}
?>
