<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');
    class Article extends Controller{
        protected $mysqli;
        public function __construct(){
            $this->mysqli = &load_class('mysqlidb');
        }

        public function index() {
            $this->display('index');
        }

        public function test(){
            $res['result'] = $this->mysqli->get('test');
            $this->display('test', $res);
        }

        //写博客
        public function write(){
            $article_model = $this->model('article');
            $name = $article_model->getName();
            $data['name'] = $name;
            $this->display('write', $data);
        }
    }
?>
