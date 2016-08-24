<?php
    define('PROJECT_FOLDER',dirname(__FILE__));
    define('SYSTEM_PATH', PROJECT_FOLDER.'/system');
    define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
    define('APP_PATH', PROJECT_FOLDER.'/application');

    require_once SYSTEM_PATH.'/core/Blog.php';
?>
