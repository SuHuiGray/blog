<!DOCTYPE html>
<?php session_start();?>
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
        <?php foreach($tags as $v){?>
            <li><?php echo $v;?></li>
        <?php }?>
    </ul>
    <p id="write" class="lab">写文章</p><p id='tag-manage' class="lab">标签管理</p>
</div>

<!-- 博客列表 -->
<div id="content" class="content">
    <div id="content-body"></div>
    <div id="page-content" class="tc"></div>
</div>

<!-- 查看博客 -->
<div id="preview-back"><span id="hide-preview">Back</span><span id="preview-title"></span></div>

<script type="text/javascript" src="<?php echo res('js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo url('editor/editormd.js'); ?>"></script>
<script type="text/javascript" src="<?php echo res('js/page.js'); ?>"></script>
<script type="text/javascript" src="<?php echo res('js/tmpl.js'); ?>"></script>
<script type="text/tmpl" id="article_tmpl">
    <%if(list && list.length>0){for(var i=0; i<list.length; i++){var v=list[i]; %>
        <div class="item"><a data-id="<%=v.id%>"><%=v.title%></a><p class="edit">编辑</p><p class="delete">删除</p><p class="summary"><%=v.summary%></p><p class="date"><%=v.create_time%></p></div>
    <%}}%>
</script>
<script type="text/javascript">
var editor;
$(document).ready(function(){
    //写文章链接
    $("#write").on('click', function(){
        window.location.href = "<?php echo url('article/write');?>";
    });

    //文章管理
    $("#tag-manage").on('click', function(){
         window.location.href = "<?php echo url('article/articles');?>"
    });

    //分页
    var $page_content = $("#page-content"),
        $content_body = $("#content-body");
    $page_content.page({
        url : "<?php echo url('article/articles'); ?>",
        params : {},
        success : function(data){
            var html = template('article_tmpl', {list:data['data']});
            console.log(data);
            $content_body.empty().html(html);

            //查看文章内容
            $(".item a").on("click", function(){
                var id = $(this).data("id");
                if(id == '' || id == undefined){
                    alert("未知错误，请查看其它文章");
                    return 0;
                }
                $.ajax({
                    url : "<?php echo url('article/getContentById');?>",
                    method : "post",
                    data : {"id":id},
                    success : function(data){
                        console.log(data);
                        data = JSON.parse(data);
                        $("#preview-title").text(data.title);
                        $.getScript("<?php echo url('editor/editormd.js'); ?>", function() {
                            $("#preview-back").after("<div id=\"preview-div\"><textarea style=\"display:none\"></textarea></div>");
                            editor = editormd("preview-div",{
                                width : "60%",
                                height : $(window).height()-100,
                                path : "<?php echo url('editor/lib'); ?>",
                                markdown : data.content,
                                onload : function(){
                                    this.previewing();
                                    $(".editormd-preview-close-btn").css("visibility","hidden");
                                },
                            });
                            $("#content").css("display","none");
                            $("#preview-back").css("display", "block");
                            //隐藏浏览界面
                            $("#hide-preview").on("click", function(){
                                $("#preview-back").css("display", "none");
                                editor.editor.remove();
                                $("#content").css("display","inline-block");
                            });
                        });

                    }
                });
            });



            //显示管理员操作
            <?php if(isset($_SESSION['user']) && !empty($_SESSION['user'])){?>
                $(".item").on("mouseover", function(){
                    $(this).find(".edit, .delete").css("display", "inline-block");
                });

                $(".item").on("mouseout", function(){
                    $(this).find(".edit, .delete").css("display", "none");
                });
            <?php }?>
        }
    });

    //显示登录界面
    $("#myIcon").on('click', function(){
        //灰色遮罩
        $("body").append("<div id='mask'></div>");
        $("#mask").css({"width":$(window).width(), "height":$(window).height(), "z-index":"10"});

        //登录界面
        var login_str = '<div id="layer" ><p id="layer-text" >登录</p><p id="close"></p><input id="usn" type="text" placeholder="username" class="login-input"><input id="psd" type="password" placeholder="password" class="login-input"><span id="login-btn">登录</span></div>';
        $("body").append(login_str);
        var login_top = ($(window).height()-$("#layer").height())/2,
            login_left = ($(window).width()-$("#layer").width())/2;
        $("#layer").css({"top":login_top, "left":login_left});

        //关闭登录界面
        $("#close").on("click", function(){
            $("#layer,#mask").remove();
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
                        window.locatoin.reload();
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
