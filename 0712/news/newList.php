<?php
//引入db类
@require "./DB.class.php";
//实例化db类
$db = DB::getInstance();
//获得所有新闻
$rows = $db -> fetchAll("select * from news");
//开启ob缓存
ob_start();
//设置字符集
echo "<meta charset='utf8'>";
?>
<h2>新闻列表</h2> <h5><a href="add.html">添加新闻</a> </h5>
<table border="1">
    <tr>
        <th>新闻编号</th>
        <th>新闻标题</th>
        <th>发布时间</th>
        <th>相关操作</th>
    </tr>
    <?php foreach($rows as $row):?>
    <tr>
        <td><?=$row['id']?></td>
        <td><?=$row['title']?></td>
        <td><?=$row['time']?></td>
        <td><a href="edit.php?id=<?=$row['id']?>">修改/编辑</a>&ensp;<a href="delete.php?id=<?=$row['id']?>">删除新闻</a>&ensp;<a href="news<?=$row['id']?>.html">查看新闻</a></td>
    </tr>
    <?php endforeach;?>
</table>
<?php
//获取ob缓存中的内容
$str = ob_get_contents();
//讲内容写入html页面中
file_put_contents("./newlist.html",$str);
?>
