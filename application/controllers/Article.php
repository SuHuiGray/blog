<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');
    class Article extends Controller
    {
        //数据库链接
        protected $mysqli;

        //文章操作模型
        protected $article_model;
        public function __construct()
        {
            $this->mysqli = &load_class('mysqlidb');
            $this->article_model = $this->model('article');
        }

        public function index()
        {
            $this->display('index');
        }

        public function test()
        {
            $res['result'] = $this->mysqli->get('test');
            $this->display('test', $res);
        }

        //显示编辑器
        public function write()
        {
            $this->display('write');
        }

        //发布博客
        public function publication()
        {
            /*$arr = array();
            if(!empty($_POST['title'])){
                $arr['title'] = $_POST['title'];
            }
            if(!empty($_POST['content'])){
                $arr['content'] = $_POST['content'];
            }
            if(!empty($_POST['tag'])){
                $arr['tag'] = $_POST['tag'];
            }
            $arr['create_time'] = date('Y-m-d H:i:s');
            $insert_id = $this->article_model->add($arr);
            if($insert_id){
                json(1,'add success', $insert_id);
            }*/
            exit(json_encode($_POST));
        }
    }
?>
