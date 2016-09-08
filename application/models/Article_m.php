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
            $sql = 'SELECT id, title, content, create_time FROM article WHERE 1=1 ';
            $sql = empty($tag) ? $sql : $sql . ' AND tag="'.$tag.'"';
            $sql = empty($title) ? $sql : $sql . ' AND title like "%'.$title.'%"';
            $sql .= ' ORDER BY id DESC';
            $sql = empty($limit) ? $sql : $sql . $limit;
            return $this->mysqli->fetchAll($sql);
            // return $sql;
        }

        /**
         * return the title and content according to the given id
         * @param integer   id      article id
         * @return array    result array contain title & content
         */
        public function getContent($id)
        {
            $sql = 'SELECT title, content FROM article WHERE id='.$id;
            return $this->mysqli->fetchOne($sql);
        }

        /**
         * edit article and return affect rows
         * @param array  $arr   the data array content title, content, tags, id
         * @param array  $where  the condition array
         * @return integer  affect rows
         */
        public function edit($arr, $condition)
        {
            $where = ' WHERE 1=1 ';
            foreach($condition as $k=>$v)
            {
                $where .= " AND $k='$v' ";
            }
            return $this->mysqli->update("article", $arr, $where);
        }
    }
?>
