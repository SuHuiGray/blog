<?
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');

    /*加载类的方法*/
    if(!function_exists('load_class')){
        function &load_class($class, $dir='core', $param = NULL)
        {
            //存放已经加载过的类
            static $classes = array();
            //如果已经加载，返回
            if(isset($classes[$class])) {
                return $classes[$class];
            }

            $class = ucfirst($class);
            $file = SYSTEM_PATH.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$class.'.php';
            if(!file_exists($file)){
                exit($file.' not exists');
            }
            require_once $file;
            $classes[$class] = isset($param) ? new $class($param) : new $class();
            return $classes[$class];
        }
    }

    /*返回静态资源的路径*/
    if(!function_exists('res')){
        function res($uri = '')
        {
            if(empty(pathinfo($uri, PATHINFO_EXTENSION )))
                return dirname($_SERVER['SCRIPT_NAME']).'/res/'.$uri.'/';
            else
                return dirname($_SERVER['SCRIPT_NAME']).'/res/'.$uri;
        }
    }

    /*返回指定控制器的路径*/
    if(!function_exists('url')){
        function url($uri = '')
        {
            if(empty(pathinfo($uri, PATHINFO_EXTENSION )))
                return dirname($_SERVER['SCRIPT_NAME']).'/'.$uri.'/';
            else
                return dirname($_SERVER['SCRIPT_NAME']).'/'.$uri;
        }
    }

    /*获取全部configu*/
    if(!function_exists('get_config')){
        function &get_config($addition = array())
        {
            static $config;
            if(empty($config)){
                $config_path = APP_PATH.'/config/config.php';
                if(file_exists($config_path)){
                    require_once $config_path;
                }
                else {
                    exit('系统中没有找到配置文件！');
                }
            }

            /*动态添加或者修改的配置*/
            foreach($addition as $k=>$v){
                $config[$k] = $v;
            }
            return $config;
        }
    }

    /*获取配置文件中的某一项*/
    if(!function_exists('config_item')){
        function config_item($item)
        {
            static $config;
            if(empty($config)){
                // references cannot be directly assigned to static variables, so we use an array
                $config[0] = &get_config();
            }

            return isset($config[0][$item]) ? $config[0][$item] : NULL;
        }
    }

    /*返回json格式的数据*/
    if(!function_exists('json')){
        function json($ok=1, $msg='', $data='')
        {
            $ret = array();
            $ret['ok'] = $ok;
            if(!empty($msg)){
                $ret['msg'] = $msg;
            }
            if(!empty($data)){
                $ret['data'] = $data;
            }
            exit(json_encode($ret));
        }
    }

?>
