<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');
    class Mysqlidb {
        private $db_config;
        //面向过程的链接
        private $conn;
        //面向对象的对象
        private $mysqli;

        public function __construct(){
            $this->db_config = config_item('db');
            $this->conn = mysqli_connect($this->db_config['host'], $this->db_config['username'], $this->db_config['password'], $this->db_config['database']) OR die('Error connect to mysql');
            //$this->mysqli = new mysqli($this->db_config['host'], $this->db_config['username'], $this->db_config['password'], $this->db_config['database']) OR die('Error connect to mysql');
            mysqli_query($this->conn, "set names utf8");
        }

        public function connectOk(){
            if($this->conn)
                echo 'ok';
        }

        //执行查询语句
        public function query($sql){
            return mysqli_query($this->conn, $sql);
        }

        //获取数据表中的所有字段
        public function get($table){
            return $this->fetchAll('select * from '.$table);
        }

        //获取所有的结果集
        public function fetchAll($sql){
            //存放结果集的数组
            $rows = array();
            if($result = mysqli_query($this->conn, $sql)){
                while($row = mysqli_fetch_assoc($result)){
                    $rows[] = $row;
                }
            }
            return $rows;
        }

        //获取结果集中的第一行
        public function fetchOne($sql){
            $res = $this->query($sql);
            $row = mysqli_fetch_assoc($res);
            return empty($row) ? '' : $row;
        }

        //执行增删改语句
        public function dml($sql){
            if(mysqli_query($this->conn, $sql)){
                if(($num=myslqi_affect_rows()) > 0){
                    //返回影响的行数
                    return $num;
                }
                else{
                    return 0;
                }
            }
            else {
                return NULL;
            }
        }

        //插入语句,参数arr是关联数组，key是数据库字段，value是要插入的值
        public function insert($table, $arr){
            //构造一个插入字符串
            $insert_str = 'insert into ' . $table . ' (' . implode(',', array_keys($arr)) . ') values (\'' . implode('\',\'', array_map(array(__CLASS__, '_addslashes'), array_values($arr))) . '\')';
            $res = mysqli_query($this->conn, $insert_str);
            return mysqli_insert_id($this->conn);
//            return $insert_str;
        }

        //更新数据库，参数是表名，关联数组，条件
        public function update($table, $arr = array(), $where){
            $update_str = 'update ' . $table .' set ';
            foreach($arr as $k=>$v){
                $update_str = $update_str . $k . '=' . "'$v',";
            }
            $update_str = substr($update_str, 0, -1) . ' '. $where;
            return $this->dml($update_str);
        }

        //为插入数据库的数据转义
        protected function _addslashes($v){
            if(get_magic_quotes_gpc()){
                return $v;
            }
            else
                return mysqli_real_escape_string($this->conn, $v);
        }
    }
?>
