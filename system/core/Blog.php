<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');

    require_once SYSTEM_PATH.'/helper/func.php';
    require_once SYSTEM_PATH.'/core/Controller.php';
    // var_dump(config_item('db'));

    $uri = &load_class('uri');

    $route = &load_class('router');
    // $db = &load_class('mysqli');
    // $db->connectOk();
    require_once $route->getDir().$route->getController().'.php';
    $c = $route->getController();
    $method =  $route->getMethod();
    $controller = new $c();
    $controller->$method();
?>
