<!DOCTYPE html>
<html>
<head>
    <title>blog</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" style="text/css" href="<?php echo res('css/base.css');?>">
</head>
<style type="text/css">

</style>
<body>
<div id="pannelLeft" class="pannel-left">
    <img src="<?php echo res('img/portrait.jpg')?>" id="myIcon" class="portrait">
    <span class="nameSpan">Gray</span>
    <ul id="nav" class="nav"><span>文章分类</span>
        <li>C/C++</li>
        <li>Linux</li>
        <li>PHP</li>
        <li>JavaScript</li>
        <li>Python</li>
    </ul>
    <p id="write" class="lab">写文章</p><p id='tag-manage' class="lab">标签管理</p>
</div>

<div id="content" class="content">
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

    <div class="item">
        <a>title</a>
        <p>contentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontentcontent</p>
        <!-- <span class='eye'></span><span class='num'>35</span><span class='eye'></span><span class='num'>35</span> -->
        <p class="date">2016-10-02</p>
    </div>
</div>

<script type="text/javascript" src="<?php echo res('js/jquery.js'); ?>"></script>
<script>
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

});
</script>
</body>
</html>
