<!DOCTYPE html>
<html>
<head>
    <title>blog</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" style="text/css" href="<?php echo res('css/base.css');?>">
    <link rel="stylesheet" href="<?php echo url('editor/css/editormd.css'); ?>">
</head>
<style type="text/css">

</style>
<body>

<!-- 左侧导航 -->
<div id="pannelLeft" class="pannel-left">
    <img src="<?php echo res('img/portrait.jpg')?>" id="myIcon" class="portrait">
    <span class="nameSpan">Gray</span>
    <ul id="nav" class="nav"><span>文章分类</span>
       <!--  <li>C/C++</li>
        <li>Linux</li>
        <li>PHP</li>
        <li>JavaScript</li>
        <li>Python</li> -->
        <?php foreach($tags as $v){?>
            <li><?php echo $v;?></li>
        <?php }?>
    </ul>
    <p id="write" class="lab">写文章</p><p id='tag-manage' class="lab">标签管理</p>
</div>

<!-- 顶部导航 -->
<span id="top-nav">导航</span>

<!-- 博客列表 -->
<div id="content" class="content">
    <?php foreach($articles as $v){?>
       <div class="item">
            <a><?php echo $v['title'];?></a>
            <p><?php $str = preg_replace('/[A-Za-z`]+/', '', $v['content']); strlen($str)>160 ? mb_substr($str, 0, 160, 'utf-8').'...' : $str; ?></p>
            <!-- <span class='eye'></span><span class='num'>35</span><span class='eye'></span><span class='num'>35</span> -->
            <p class="date"><?php echo $v['create_time'];?></p>
        </div>
    <?php }?>
    <div class="item">
        <a>标题</a>
        <p>我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的我的</p>
        <!-- <span class='eye'></span><span class='num'>35</span><span class='eye'></span><span class='num'>35</span> -->
        <p class="date">2016-10-02</p>
    </div>

    <div class="item">
        <a>title</a>
        <p>contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent</p>
        <!-- <span class='eye'></span><span class='num'>35</span><span class='eye'></span><span class='num'>35</span> -->
        <p class="date">2016-10-02</p>
    </div>

    <div class="item">
        <a>title</a>
        <p>contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent</p>
        <!-- <span class='eye'></span><span class='num'>35</span><span class='eye'></span><span class='num'>35</span> -->
        <p class="date">2016-10-02</p>
    </div>
</div>

<!-- 查看博客 -->
<!-- <div id="watch" style="display:none"> -->
    <input type="hidden" id="title" value="title">
    <div id="preview-div">
        <textarea id="preview" style="display:none"></textarea>
    </div>
<!-- </div> -->

<script type="text/javascript" src="<?php echo res('js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo url('editor/editormd.js'); ?>"></script>
<script type="text/javascript">
var editor;
$(document).ready(function(){
    //写文章链接
    $("#write").on('click', function(){
        window.location.href = "<?php echo url('article/write');?>";
    });

    //文章管理
    $("#tag-manage").on('click', function(){
        window.location.href = "<?php echo url('article/manage');?>"
    });

    //显示登录界面
    $("#myIcon").on('click', function(){
        //灰色遮罩
        $("body").append("<div id='mask'></div>");
        $("#mask").css({"width":$(window).width(), "height":$(window).height(), "z-index":"10"});

        //登录界面
        var login_str = '<div id="login" ><p id="login-text" >登录</p><p id="close"></p><input id="usn" type="text" placeholder="username" class="login-input"><input id="psd" type="password" placeholder="password" class="login-input"><span id="login-btn">登录</span></div>';
        $("body").append(login_str);
        var login_top = ($(window).height()-$("#login").height())/2,
            login_left = ($(window).width()-$("#login").width())/2;
        $("#login").css({"top":login_top, "left":login_left});

        //关闭登录界面
        $("#close").on("click", function(){
            $("#login,#mask").remove();
        });

        //登录
        $("#login-btn").on("click", function(){
            $.ajax({
                url : "<?php echo url('home/login');?>",
                method : "post",
                data : {"usn":$("#usn").val(), "psd":$("#psd").val()},
                success : function(data){
                    data = JSON.parse(data);
                    if(data.ok){
                        $("#close").trigger('click');
                    }
                    else {
                        alert(data.msg);
                    }
                },
                error : function(XMLHttpResponse){
                    alert(XMLHttpResponse.responseText)
                }
            });
        });
    });

    //浏览文章
    editor = editormd("preview-div",{
        width : "60%",
        height : $(window).height()-100,
        path : "<?php echo url('editor/lib'); ?>",
        onload : function(){
            this.previewing();
            this.hide();
        },
    });

    $("#content a").on("click", function(){
        $("#content").css("display","none");
        $("#title").attr("type", "text");
        editor.show();
    });
});
</script>
</body>
</html>
