<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');
    class Article extends Controller{
        public function __construct(){
            /*$model = new ArticleModel();
            $name = $model->getName();
            $view = new ArticleView();
            $view->show($name);*/
        }
        public function index() {
            $arr = array(
                'pattern' => 'kkk',
            );
            $this->display('article', $arr);
        }

        public function test(){
            $mysqli = &load_class('mysqlidb');
            $res['result'] = $mysqli->get('test');
            $this->display('test', $res);
        }
    }
?>
