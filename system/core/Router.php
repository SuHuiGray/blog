<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');
    class Router {
        /*
         *默认的控制器和方法
         */
        protected $controller = 'Home';
        protected $method = 'index';
        /*
         *segments  --解析后的uri中各段，控制器和方法
         */
        protected $segments = array();

        /*
         *directory     --控制器所在目录
         */
        protected $directory = APP_PATH.'/controllers/';

        public function __construct() {
            $uri = &load_class('uri');
            $uri_str = $uri->getUri();
            $this->setRoute($uri_str);
        }

        /*
         *设置路由
         */
        protected function setRoute($uri_str){
            if(empty($uri_str) || $uri_str == '/'){
                return ;
            }

            $segments = explode('/', $uri_str);

            $segments = $this->validateRequest($segments);

             $this->controller = empty($tmp = array_shift($segments)) ? 'Home' : ucfirst($tmp);
             $this->method = empty($tmp = array_shift($segments)) ? 'index' : $tmp;
        }

        protected function validateRequest($segments){
            $c = count($segments);
            while($c-- > 0){
                if(!file_exists($this->directory.'/'.$segments[0].'.php') && is_dir($this->directory.'/'.$segments[0])){
                    $this->directory .= '/'.trim($segments[0]);
                    array_shift($segments);
                }
            }
            return $segments;
        }

        public function getController(){
            return $this->controller;
        }

        public function getMethod(){
            return $this->method;
        }

        public function getDir(){
            return $this->directory;
        }
    }
?>
