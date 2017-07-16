<?php
function alert($info,$url){
    echo '<script type="text/javascript">alert("'.$info.'");location.href="'.$url.'";</script>';
}
$id = $_GET['id'];
$title = $_POST['title'];
$content = $_POST['content'];

//引入db类
require "./DB.class.php";
//实例化对象
$db = DB::getInstance();

$db->query("update news set title='{$title}',content='{$content}' where id={$id}");
//引入更新列表
require "./newList.php";
//引入更新新闻详情
require "./newsProuct.php";

alert("编辑修改成功","newlist.html");