<!DOCTYPE html>
<html>
<head>
    <title>查看博文</title>
    <link rel="shortcut icon" href="<?php echo url('favicon.ico'); ?>">
    <link rel="stylesheet" href="<?php echo url('editor/css/editormd.css'); ?>">
</head>
<style type="text/css">
    *{margin:0; padding:0;}
    html{font-family:Verdana, sans-serif, 'MicroSoft Yahei'; font-size:16px;}
    #articleTitle{margin-left:0.5%; font-size:2em; margin-bottom:10px;}
</style>
<body>
<p id="articleTitle"></p>
<div id="preview"></div>

<script type="text/javascript" src="<?php echo res('js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo url('editor/editormd.js'); ?>"></script>
<script type="text/javascript">
    var editor;

    $(function(){
        $.ajax({
            url : "<?php echo url('article/getContentByStamp');?>",
            method : "get",
            data : {"stamp" : "<?php echo $stamp;?>"},
            success : function(data){
                data = JSON.parse(data);
                $("#articleTitle").text(data.title);
                $.getScript("<?php echo url('editor/editormd.js'); ?>", function(){
                    editor = editormd("preview",{
                        width : "99%",
                        height : $(window).height()-70,
                        path : "<?php echo url('editor/lib'); ?>",
                        markdown : data.content,
                        onload : function(){
                            this.previewing();
                            $(".editormd-preview-close-btn").css("visibility","hidden");
                        }
                    });
                });
            }
        });
    });
</script>
</body>
</html>
