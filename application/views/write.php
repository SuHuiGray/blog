<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>写博客</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url('editor/css/editormd.css'); ?>">
    <link rel="stylesheet" href="<?php echo res('css/base.css');?>">
</head>
<body>
<form id="article" name="article" method="post">
    <input id="title" name="title" type="text" class="atitle" placeholder="请输入文章标题"><input type="button" id="publication" class='submit-btn' value="发表博客"><input type="button" id="backToList" class='submit-btn' value="返回列表">
    <div id="myeditor">
        <textarea id="content" name="content" style="display:none"></textarea>
    </div>

</form>

<script type="text/javascript" src="<?php echo res('js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('editor/editormd.js'); ?>"></script>
<script type="text/javascript">
    var editor;
    $(function(){
        editor = editormd("myeditor", {
            width : "99%",
            height : $(window).height()-100,
            path : "<?php echo base_url('editor/lib'); ?>",
            // theme : "dark",
            // editorTheme : "dark",
            // previewTheme : "dark",
            //markdown : md,
            codeFold : true,
            //syncScrolling : false,
            saveHTMLToTextarea : true,    // 保存 HTML 到 Textarea
            searchReplace : true,
            //watch : false,                // 关闭实时预览
            htmlDecode : "style,script,iframe|on*",            // 开启 HTML 标签解析，为了安全性，默认不开启
            //toolbar  : false,             //关闭工具栏
            //previewCodeHighlight : false, // 关闭预览 HTML 的代码块高亮，默认开启
            emoji : true,
            taskList : true,
            tocm            : true,         // Using [TOCM]
            tex : true,                   // 开启科学公式TeX语言支持，默认关闭
            flowChart : true,             // 开启流程图支持，默认关闭
            sequenceDiagram : true,       // 开启时序/序列图支持，默认关闭,
            //dialogLockScreen : false,   // 设置弹出层对话框不锁屏，全局通用，默认为true
            //dialogShowMask : false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为true
            //dialogDraggable : false,    // 设置弹出层对话框不可拖动，全局通用，默认为true
            //dialogMaskOpacity : 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为0.1
            //dialogMaskBgColor : "#000", // 设置透明遮罩层的背景颜色，全局通用，默认为#fff
            imageUpload : true,
            imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL : "<?php echo base_url('editor/php/upload.php'); ?>",
            onload : function() {
                console.log('onload', this);
                //this.fullscreen();
                //this.unwatch();
                //this.watch().fullscreen();

                //this.setMarkdown("#PHP");
                //this.width("100%");
                //this.height(480);
                //this.resize("100%", 640);
                this.previewing();
            }
        });

        $("#backToList").on("click", function(){
            window.location.href = "<?php echo base_url('article'); ?>";
        });

        $("#publication").on("click", function(){
            if($("#title").val() == ''){
                alert('请输入文章标题');
                return 0;
            }
            $.ajax({
                type : "post",
                url : "<?php echo base_url('article/publication');?>",
                data : $("#article").serialize(),
                success : function(data){
                    console.log(data);
                    // alert(data);
                }
            });
        });

        $(".editormd-preview-close-btn").css("visibility", "hidden");
    });
</script>
</body>
</html>
