<?php
$id = $_GET['id'];
//引入db类
require "./DB.class.php";
//实例化对象
$db = DB::getInstance();
//查询该新闻数据
$row = $db -> fetchRow("select * from news where id={$id}");
?>
<h2>编辑新闻详情</h2>
<form action="action.php?id=<?=$row['id']?>" method="post">
    新闻标题 <input type="text" name="title" value="<?=$row['title']?>"><br/>
    新闻内容 <input type="text" name="content" value="<?=$row['content']?>"><br/>
    <input type="submit" value="编辑/修改">
</form>
