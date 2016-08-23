<?php
    class ArticleModel {
        protected $name;
        public function __construct(){
            $this->name = 'gray';
        }

        public function getName(){
            return $this->name;
        }
    }
?>
