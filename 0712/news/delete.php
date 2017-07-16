<?php
//接收id
$id = $_GET['id'];
//引入db类
require "./DB.class.php";
//实例化对象
$db = DB::getInstance();
//删除新闻
$db -> query("delete from news where id={$id}");

//引入更新列表
require "./newList.php";
//删除新闻详情静态页面
unlink("./news$id.html");

function alert($info,$url){
    echo '<script type="text/javascript">alert("'.$info.'");location.href="'.$url.'";</script>';
}

alert("删除新闻成功","newlist.html");