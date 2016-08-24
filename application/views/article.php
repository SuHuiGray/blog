<?php
    /*class ArticleView {
        public function show($name) {
            ob_start();
            eval('?>'.file_get_contents('test.php'));
            ob_end_flush();
        }
    }*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>article</title>
</head>
<body>
<h1>Hello<?php echo ' World'; ?></h1>
<?php for($i=0; $i<3; $i++){?>
    <p>this is paragraph<?php echo $i.$pattern; ?></p>
<?php }?>
</body>
</html>
