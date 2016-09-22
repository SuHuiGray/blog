<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');
$start_time = microtime(true);
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
    $args = $route->getArgs();
    $controller = new $c();
    $controller->$method($args);
    $end_time = microtime(true);
    //echo number_format($end_time - $start_time, 4);
?>
