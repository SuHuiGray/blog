<?
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');
    if(!function_exists('load_class')){
        function &load_class($class, $dir='core', $param = NULL) {
            //存放已经加载过的类
            static $classes = array();
            //如果已经加载，返回
            if(isset($classes[$class])) {
                return $classes[$class];
            }

            $class = ucfirst($class);
            $file = SYSTEM_PATH.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$class.'.php';
            if(!file_exists($file)){
                exit($file.'not exists');
            }
            require_once $file;
            $classes[$class] = isset($param) ? new $class($param) : new $class();
            return $classes[$class];
        }
    }
?>
