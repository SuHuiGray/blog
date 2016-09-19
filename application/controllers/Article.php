<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');
    header("Content-type:text/html; charset=utf-8");
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
            $data['tags'] = $this->article_model->getAllTags();
            $this->display('index', $data);
        }

        //显示编辑器
        public function write()
        {
            $data['id'] = '';
            if(isset($_GET['id']) && !empty($_GET['id'])){
                $data['id'] = $_GET['id'];
                /*$content = $this->article_model->getContent($_GET['id']);
                $data['title'] = $content['title'];
                $data['content'] = $content['content'];*/
            }
            $this->display('write', $data);
        }

        //发布博客
        public function publication()
        {
            $arr = array();
            if(!empty($_POST['title'])){
                $arr['title'] = $_POST['title'];
            }
            if(!empty($_POST['content'])){
                $arr['content'] = $_POST['content'];
            }
            if(!empty($_POST['tag'])){
                $arr['tag'] = $_POST['tag'];
            }
            if(isset($_GET['action']) && !empty($_GET['action'])){
                $where['id'] = $_GET['id'];
                $res = $this->article_model->edit($arr, $where);
                if(is_numeric($res) && $res){
                    json(1, 'edit success', $res);
                }
                else if(is_numeric($res) && 0 === $res){
                    json(0, 'no changes');
                }
                else {
                    json(0, 'error', $res);
                }
            }
            $arr['create_time'] = date('Y-m-d H:i:s');
            $insert_id = $this->article_model->add($arr);
            if($insert_id){
                $this->article_model->tag_operate($arr['tag']);
                json(1,'add success', $insert_id);
            }
        }

        //获取所有标签
        public function tags()
        {
            $arr = $this->article_model->getAllTags();
            json(1, 'success', $arr);
        }

        //获取所有文章,分页
        public function articles()
        {
            $current = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : '';
            $size =isset($_GET['size']) && !empty($_GET['size']) ? $_GET['size'] : '';
            $tag = '';
            $title = '';
            if(empty($current) || !is_numeric($current)) $current = 1;
            if(empty($size) || !is_numeric($size)) $size = 10;

            if(isset($_GET['tag']) && !empty($_GET['tag']))
                $tag = $_GET['tag'];
            if(isset($_GET['title']) && !empty($_GET['title']))
                $title = $_GET['title'];

            $tmp_article = $this->article_model->getArticles($tag, $title);
            $result['total'] = ceil(count($tmp_article)/$size);
            $limit = " limit ".($current-1)*$size.",".$size;
            $tmp_article = $this->article_model->getArticles($tag, $title, $limit);
            foreach($tmp_article as $key=>$v){
                $summary = preg_replace('/(```(.|\n)+?```)+/', '', $v['content']);
                $summary = strlen($summary)>160 ? mb_substr($summary, 0, 160, 'utf-8').'...' : $summary;
                $tmp_article[$key]['summary'] = $summary;
                unset($tmp_article[$key]['content']);
            }
            $result['current'] = $current;
            $result['data'] = $tmp_article;
            exit(json_encode($result));
        }

        //根据id获取文章内容
        public function getContentById()
        {
            $id = $_POST['id'];
            if(!empty($id)){
                $content = $this->article_model->getContent($id);
            }
            else {
                $content['title']  = '';
                $content['content'] = '';
            }
            exit(json_encode($content));
        }

        //删除指定id的文章
        public function deleteArticleById(){
            $id = $_GET['id'];
            $content = $this->article_model->getContent($id);
            $tagName = $content['tag'];
            $affect_row = $this->article_model->deleteById($id);
            if($affect_row){
                $this->article_model->tag_operate($tagName, true);
                json(1, '删除成功');
            }
            else
                json(0, '删除失败');
        }
    }
?>
