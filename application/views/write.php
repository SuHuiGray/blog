<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>写博客</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="<?php echo url('editor/css/editormd.css'); ?>">
    <link rel="stylesheet" href="<?php echo res('css/base.css');?>">
    <link rel="stylesheet" style="text/css" href="<?php echo res('css/dialog.css');?>">
</head>
<body>
<form id="article" name="article" method="post">
    <input type="hidden" id="tag" name="tag">
    <input id="title" name="title" type="text" class="atitle" placeholder="请输入文章标题"><input type="button" id="publication" class='submit-btn' value="发表博客"><input type="button" id="backToList" class='submit-btn' value="返回列表">
    <div id="myeditor">
        <textarea id="content" name="content" style="display:none"></textarea>
    </div>

</form>

<script type="text/javascript" src="<?php echo res('js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo url('editor/editormd.js'); ?>"></script>
<script type="text/javascript">
    var editor;
    $(function(){
        $("#title").val("<?php echo empty($title) ? '' : $title?>");
        editor = editormd("myeditor", {
            width : "99%",
            height : $(window).height()-100,
            path : "<?php echo url('editor/lib'); ?>",
            // theme : "dark",
            // previewTheme : "dark",
            // editorTheme : "pastel-on-dark",
            markdown : "<?php echo empty($content) ? '' : $content?>",
            codeFold : true,
            //syncScrolling : false,
            saveHTMLToTextarea : true,    // 保存 HTML 到 Textarea
            searchReplace : true,
            //watch : false,                // 关闭实时预览
            htmlDecode : "style,script,iframe|on*",            // 开启 HTML 标签解析，为了安全性，默认不开启
            taskList : true,
            tocm            : true,         // Using [TOCM]
            tex : true,                   // 开启科学公式TeX语言支持，默认关闭
            flowChart : true,             // 开启流程图支持，默认关闭
            sequenceDiagram : true,       // 开启时序/序列图支持，默认关闭,
            imageUpload : true,
            imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL : "<?php echo url('editor/php/upload.php'); ?>",
        });

        $("#backToList").on("click", function(){
            window.location.href = "<?php echo url('article'); ?>";
        });

        $("#publication").on("click", function(){
            if($("#title").val() == ''){
                alert('请输入文章标题');
                return 0;
            }
            $.ajax({
                type : "post",
                url : "<?php echo url('article/tags');?>",
                data : '',
                success : function(data){
                    // console.log(data);
                    data = JSON.parse(data);
                    var tags_arr = data.data;
                    //灰色遮罩
                    $("body").append("<div id='mask'></div>");
                    $("#mask").css({"width":$(window).width(), "height":$(window).height(), "z-index":"10"});

                    //选择标签
                    var tag_str = '<div id="layer" ><p id="layer-text" >选择标签</p><p id="close"></p><br>';
                    for(var i=0; i<tags_arr.length; i++){
                        tag_str += '<span class="tag-span">'+tags_arr[i]+'</span>';
                    }
                    tag_str += '<div id="tag-store"></div><span id="login-btn">确定</span></div>';

                    $("body").append(tag_str);
                    var layer_top = ($(window).height()-$("#layer").height())/2,
                        layer_left = ($(window).width()-$("#layer").width())/2;
                    $("#layer").css({"top":layer_top, "left":layer_left});

                    //关闭登录界面
                    $("#close").on("click", function(){
                        $("#layer,#mask").remove();
                    });

                    //选择标签
                    $(".tag-span").on("click", function(){
                        $(this).addClass("select");
                        $("#tag-store").append("<span>"+$(this).text()+"</span>");

                        //移除已选标签
                        $("#tag-store span").on("click", function(){
                            var select_tag = $(this);
                            $(".select").each(function(index, obj){
                                if($(obj).text() == select_tag.text()){
                                    $(obj).removeClass("select");
                                    select_tag.remove();
                                }
                            });
                        });
                    });

                    //发布
                    $("#login-btn").on("click", function(){
                        $("#tag").val($("#tag-store span").text());
                        $.ajax({
                            type : "post",
                            url : "<?php echo url('article/publication');?>" + "<?php echo empty($id) ? '' : '?action=edit&id='.$id?>",
                            data : $("#article").serialize(),
                            success : function(data){
                                data = JSON.parse(data);
                                if(data.ok){
                                    $("#mask,#layer").remove();
                                    alert(data.msg);
                                    console.log(data);
                                }
                            },
                            error : function(XMLHttpResponse){
                                alert(XMLHttpResponse.responseText);
                            }
                        });
                    });
                }
            });
        });

    });
</script>
</body>
</html>
