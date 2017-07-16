<?php
//创建redis对象
$redis = new Redis();
//链接
$redis -> connect('192.168.0.101','6379');
//string类型操作
$str1 = $redis -> get('name');
echo $str1."<br/>";
$str2 = $redis -> mget(array('name','age'));
var_dump($str2);
echo "<br/>";
$str3 = $redis -> get('num');
echo $str3."<br/>";
$str4 = $redis -> get('num2');
echo $str4."<br/>";
//key类型操作
$str5 = $redis -> keys('name');
echo $str5."<br/>";
$str6 = $redis -> ttl('age');
echo $str6."<br/>";
//对list集合的操作
$str7 = $redis -> lrange('user','0','-1');
var_dump($str7);
echo "<br/>";
$str8 = $redis -> lpop('user');
var_dump($str8);
echo "<br/>";
$str9 = $redis -> rpop('username');
var_dump($str9);
echo "<br/>";
//对set集合的操作
$str10 = $redis -> smembers('member');
var_dump($str10);
echo "<br/>";
//对hash类型的操作
$str11 = $redis -> hget('sname');
echo $str11."<br/>";
$str15 = $redis -> hmget('mname',array('name','age'));
var_dump($str15);
echo "<br/>";
$str12 = $redis -> hkeys('sname');
echo $str12."<br/>";
$str13 = $redis -> hVals('sname');
echo $str13."<br/>";
$str14 = $redis -> hgetall('mname');
var_dump($str14);
