<?php
//引入DB类
require "./DB.class.php";
//实例化DB对象
$db = DB::getInstance();
//得到数据表名
$num = data("Ymd");
$tableName = "order_".$tableName;

//插入数据
$sql = "insert into {$tableName}()values()";
$db -> query($sql);

//修改数据
$sqlc = "update {$tableName} set name='{$data['name']}' where id=$id";
$db -> query($sqlc);

//删除数据
$sqlx = "delete from {$tableName} where id=$id";
$db -> query($sqlx);

//查询数据
$today = date("Ymd",time());
$torrow = strtotime("+1 day");
$day1 = date("Ymd",$torrow);
$zuotian = strtotime("-1 day");
$day2 = date("Ymd",$zuotian);

$dayArr=[$day2,$today,$day1];
$sqly="";
//利用foreach语句去拼接sql
foreach ($dayArr as $day){
    $sqly.= "select * from order_$day UNION  all ";
}
//使用rtrim去删除多余的字符串
$sqly = rtrim($sql," UNION  all ");
$rows = $db -> fetchAll($sqly);