<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');
    class Controller {

        /*
         *显示视图
         *参数param目前只能传递key=>value键值对数组
         */
        protected function display($view, $param = NULL)
        {
            $view_dir = APP_PATH.'/views/';
            $view = trim($view);
            foreach(explode('/', $view) as $v){
                if(!file_exists($view_dir.$v.'.php') && is_dir($view_dir.$v)){
                    $view_dir .= $v.'/';
                    continue;
                }
                else if (file_exists($view_dir.$v.'.php')){
                    $this->cacheView($view_dir.$v.'.php', $param);
                }
                else {
                    $this->cacheView($view_dir.'404.php', $param);
                }
            }
        }

        /*缓存视图*/
        private function cacheView($view_path, $param)
        {
            if(is_array($param))
                extract($param);
            ob_start();
            $file_str = file_get_contents($view_path);
            echo eval('?>'.$file_str);
            $output_str = ob_get_contents();
            ob_end_clean();
            echo $output_str;
        }

        //加载model
        protected function model($model_name)
        {
            $model = ucfirst($model_name).'_m';
            $file = APP_PATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$model.'.php';
            if( ! file_exists($file))
                exit('The model "'.$model.'" is not exists');
            require_once($file);
            return new $model();
        }
    }
?>
