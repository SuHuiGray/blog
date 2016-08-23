<?php
    $sys_path = 'system';
    $application_folder = 'application';

    define('PROJECT_FOLDER',dirname(__FILE__).DIRECTORY_SEPARATOR);
    define('SYSTEM_PATH', $sys_path);
    define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
    define('APP_PATH', $application_folder);

    require_once SYSTEM_PATH.'/helper/func.php';

    $uri = &load_class('uri');

    $route = &load_class('router');
    require_once $route->getDir().$route->getController().'.php';
    $c = $route->getController();
    $m =  $route->getMethod();
    $article = new $c();
    $article->$m();
?>
