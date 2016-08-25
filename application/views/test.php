<!DOCTYPE html>
<html>
<head>
    <title>test</title>
</head>
<body>
<table>
    <tr><td>姓名</td><td>性别</td><td>年龄</td></tr>
    <?php foreach($result as $val){?>
        <tr><td><?php echo $val['name']?></td><td><?php echo $val['gender']?></td><td><?php echo $val['age']?></td></tr>
    <?php }?>
</table>
<a href="<?php echo base_url('article/index');?>"><?php echo base_url('article/index');?></a>
<!-- <img src="<?php //echo res('img/hide.png');?>"> -->
</body>
</html>
