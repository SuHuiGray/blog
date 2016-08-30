<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>editor.md</title>
    <link rel="stylesheet" href="css/editormd.css" />
</head>
<body>
    <div id="layout">
    <input type="button" id="btn" value="getValue">
        <div id="myeditor">
            <textarea style="display:none;"></textarea>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="editormd.min.js"></script>
    <script type="text/javascript">
        var testEditor;
        $(function() {
            testEditor = editormd("myeditor", {
                width : "90%",
                height : 640,
                syncScrolling : "single",
                path : "lib/"
            });
        });
        var con = '```html<html><head></head></html>```';
        $("textarea").val(con);
        $("#btn").on("click", function(){
            var content = $("textarea").val();
            alert(content);
        });
    </script>
</body>
</html>
