<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed...');
    class Uri {
        protected $requestUri;
        public function __construct() {
            $this->requestUri = $this->parse_request_uri($_SERVER['REQUEST_URI']);
        }

        public function getUri(){
            return $this->requestUri;
        }

        /*
         *处理请求字符串
         */
        public function parse_request_uri($uri) {
            if(!isset($uri, $_SERVER['SCRIPT_NAME']))
                return '';
            $uris = parse_url('http://sample'.$uri);
            $query_str = isset($uris['query']) ? $uris['query'] : '';
            $uri = $uris['path'];

            /*
             *解析控制器和方法名
             */
            if(strpos($uri, $_SERVER['SCRIPT_NAME']) === 0){
                $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
            }
            else if(strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0){
                $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
            }

            /*
             *处理查询字符串，将其分割成变量存在$_GET数组中
             */
            if(!empty($query_str))
                parse_str($query_str, $_GET);

            $uri = $this->clean_request_uri($uri);
            return $uri;
        }

        public function clean_request_uri($uri_str) {
            $uris = array();
            foreach(explode('/', $uri_str) as $val) {
                if($val !== '' && $val !== '..') {
                    $uris[] = $val;
                }
            }
            return implode('/', $uris);
        }
    }
?>
