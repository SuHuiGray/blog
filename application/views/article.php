<?php
    class ArticleView {
        public function show($name) {
            ob_start();
            eval('?>'.file_get_contents('test.php'));
            ob_end_flush();
        }
    }
?>
