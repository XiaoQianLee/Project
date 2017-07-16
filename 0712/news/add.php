<?php
//获取传递的数据
$title=$_POST["title"];
$content=$_POST["content"];
//引入db类
require  './DB.class.php';
//得到实例
$db = DB::getInstance();
//执行插入语句
$db->query("insert into news set title='$title',content='$content'");

//更新新闻列表静态页面
require "./newList.php";
//生成新闻详情静态页面
require "./newsProuct.php";

function alert($info,$url){
    echo '<script type="text/javascript">alert("'.$info.'");location.href="'.$url.'";</script>';
}

alert("添加新闻成功","newlist.html");
