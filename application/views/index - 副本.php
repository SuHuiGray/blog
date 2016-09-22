<!DOCTYPE html>
<?php session_start();?>
<html>
<head>
    <title>blog</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?php echo url('favicon.ico'); ?>">
    <link rel="stylesheet" style="text/css" href="<?php echo res('css/base.css');?>">
    <link rel="stylesheet" href="<?php echo url('editor/css/editormd.css'); ?>">
    <link rel="stylesheet" style="text/css" href="<?php echo res('css/dialog.css');?>">
    <!-- <link rel="stylesheet" style="text/css" href="<?php //echo res('css/normalize.css');?>"> -->
    <!-- <link rel="stylesheet" style="text/css" href="<?php //echo res('css/style.css');?>"> -->
</head>
<style type="text/css">

</style>
<body>

<!-- 左侧导航 -->
<div id="pannelLeft" class="pannel-left">
    <img src="<?php echo res('img/portrait.jpg')?>" id="myIcon" class="portrait">
    <span class="nameSpan">Gray</span>
    <!-- <input id="search" val="s"><p id="search-icon"></p> -->
    <div id="search-wrapper">
        <input type="text" id="search" placeholder="Search article..." />
        <div id="close-icon"></div>
    </div>
    <ul id="nav" class="nav"><span>文章分类</span>
        <li>All</li>
        <?php foreach($tags as $v){?>
            <li><?php echo $v['tag_name'];?><i>(<?php echo $v['total'];?>)</i></li>
        <?php }?>
    </ul>
    <?php if(isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
    <p id="write" class="lab">写文章</p><p id='tag-manage' class="lab">标签管理</p>
    <?php } ?>
</div>

<!-- 博客列表 -->
<div id="content" class="content">
    <div id="content-body"></div><div style="display:inline-block; width:100%; height:1px"></div>
    <div id="page-content" class="tc"></div>
</div>

<!-- 查看博客 -->
<div id="preview-back"><span id="hide-preview">返回</span><span id="preview-title"></span></div><span id="preview-close"></span>

<script type="text/javascript" src="<?php echo res('js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo url('editor/editormd.js'); ?>"></script>
<script type="text/javascript" src="<?php echo res('js/page.js'); ?>"></script>
<script type="text/javascript" src="<?php echo res('js/tmpl.js'); ?>"></script>
<script type="text/javascript" src="<?php echo res('js/dialog.js'); ?>"></script>
<!-- <script type="text/javascript" src="<?php //echo res('js/search.js'); ?>"></script> -->
<script type="text/tmpl" id="article_tmpl">
    <%if(list && list.length>0){for(var i=0; i<list.length; i++){var v=list[i]; %>
        <div class="item"><a data-id="<%=v.id%>" href="<?php echo url('article/watch');?><%=v.stamp%>" target="_blank"><%=v.title%></a><?php if(isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?><p class="edit">编辑</p><p class="delete">删除</p><?php } ?><p class="summary"><%=v.summary%></p><!-- <p class="article-tag">标签:<%=v.tag%></p> --><p class="date"><%=v.create_time%></p></div>
    <%}}%>
</script>
<script type="text/javascript">
var editor;
$(document).ready(function(){
    //查询清空按钮
    $("#close-icon").on("click", function(){
        $("#search").val("");
    });

    //写文章链接
    $("#write").on('click', function(){
        window.location.href = "<?php echo url('article/write');?>";
    });

    //分页
    var $page_content = $("#page-content"),
        $content_body = $("#content-body");
    $page_content.page({
        url : "<?php echo url('article/articles'); ?>",
        params : {},
        success : function(data){
            var html = template('article_tmpl', {list:data['data']}),
                current = data.current;
            // console.log(html);
            if(html == '')
                html = '没有数据';
            $content_body.empty().html(html);

            //查看文章内容
            /*$(".item a").on("click", function(){
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
                            $("#preview-back").after("<div id=\"preview-div\"></div>");
                            editor = editormd("preview-div",{
                                width : "60%",
                                height : $(window).height()-70,
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
            });*/

            //编辑文章
            $(".edit").on("click", function(){
                window.location.href = "<?php echo url('article/write');?>"+"?id="+$(this).siblings("a").data("id");
            });

            //删除文章
            $(".delete").on('click', function(){
                var id = $(this).siblings("a").data("id");
                $.confirm({
                    width : 300,
                    height : 100,
                    cont : '确认删除?',
                    ok : function(){
                        console.log(id);
                        $.get("<?php echo url('article/deleteArticleById');?>" , {"id": id}).done(function(res){
                                res = JSON.parse(res);
                                // alert(res.msg);
                                $("#dlg-cfm-cancel").trigger("click");
                                $.alert({
                                    width : 200,
                                    height : 60,
                                    cont : res.msg,
                                    time : 1
                                });
                                // var obj = $page_content.page('obj');
                                // obj.reload(current);
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

    //点击标签加载相应文章
    $("#nav li").on("click", function(){
        var tag = $(this).text(),
            obj = $page_content.page('obj');
            tag = tag.substr(0, tag.lastIndexOf('('));
        if(tag == "All"){
            tag = '';
        }
        obj.param("tag", tag).reload(1);
        $(this).siblings("li").each(function(index, obj){
            $(obj).removeClass("select-li");
        });
        $(this).addClass("select-li");
        // alert(tag);
    });

    //搜索文章标题
    $("#search").on("keypress", function(event){
        // alert(event.keyCode);
        if(event.keyCode == "13"){
            var title = $(this).val(),
                obj = $page_content.page('obj');
            obj.param("title", title).reload(1);
        }
    });

    //显示登录界面
    $("#myIcon").on('click', function(){
        $.login({
            ok : function(){
                if($("#usn").val() == '' || $("#psd").val() == ''){
                    alert("用户名和密码不能为空");
                    return 0;
                }
                $.ajax({
                    url : "<?php echo url('home/login');?>",
                    method : "post",
                    data : {"usn":$("#usn").val(), "psd":$("#psd").val()},
                    success : function(data){
                        data = JSON.parse(data);
                        if(data.ok){
                            $("#close").trigger('click');
                            window.location.href = window.location.href;
                        }
                        else {
                            alert(data.msg);
                        }
                    }
                });
            },
        });
    });

});
</script>
</body>
</html>
