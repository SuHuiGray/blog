<?php
    class Article_m
    {
        protected $mysqli;
        public function __construct()
        {
            $this->mysqli =  &load_class('mysqlidb');
        }

        /**
         * add new article
         * @param array  $arr   the values to insert into database
         * @return integer    the insert id
         */
        public function add($arr)
        {
            return $this->mysqli->insert('article',$arr);
        }

        /**
         * get all tags
         * @return array    all tags
         */
        public function getAllTags()
        {
            $sql = 'select tag_name from tag';
            $tmp = $this->mysqli->fetchAll($sql);
            $arr = array();
            foreach($tmp as $v){
                $arr[] = $v['tag_name'];
            }
            return $arr;
        }

        /**
         * return all articles or query article by condition
         * @param string    tag     the article tag
         * @param string    title   the article title
         * @return array    result array of articles
         */
        public function getArticles($tag='', $title='', $limit='')
        {
            $sql = 'SELECT title,content,create_time FROM article WHERE 1=1 ';
            $sql = empty($tag) ? $sql : $sql . ' AND tag="'.$tag.'"';
            $sql = empty($title) ? $sql : $sql . ' AND title like "%'.$title.'%"';
            $sql = empty($limit) ? $sql : $sql . $limit;
            return $this->mysqli->fetchAll($sql);
            // return $sql;
        }
    }
?>
