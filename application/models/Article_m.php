<?php
    class Article_m {
        protected $mysqli;
        public function __construct(){
            $this->mysqli =  &load_class('mysqlidb');
        }

        /**
         * add new article
         * @param array  $arr   the values to insert into database
         * @return integer    the insert id
         */
        public function add($arr){
            return $this->mysqli->insert('article',$arr);
        }
    }
?>
