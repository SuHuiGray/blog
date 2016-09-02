<?php
    defined('PROJECT_FOLDER') OR exit('No direct script access allowed');
    class Home extends Controller
    {
        public function login()
        {
            $mysqli = &load_class('mysqlidb');
            $user_name = $_POST['usn'];
            $passwd = $_POST['psd'];
            $sql = 'select passwd from user where name="'.$user_name.'"';
            $res = $mysqli->fetchOne($sql);

            if($passwd == $res['passwd']){
                json(1, '登录成功');
            }
            else {
                json(0, '用户名或密码错误');
            }
        }
    }
?>
