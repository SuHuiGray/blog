<?php
    class ArticleController {
        public function __construct(){
            $model = new ArticleModel();
            $name = $model->getName();
            $view = new ArticleView();
            $view->show($name);
        }
    }
?>
