<?php
//创建redis对象
$redis = new Redis();
//链接
$redis -> connect('192.168.0.101','6379');
//string类型操作
$redis -> set('name','zhangsan');
$redis -> mset(array('name'=>'lxq','age'=>'21'));
$redis -> incr('num');
$redis -> decr('num2');
//key类型操作
$redis -> del('num2');
$redis -> expire('num',60);
//$redis -> flushall();//清空redis服务器数据
//对list集合的操作
$redis -> lpush('user','lxq','lll','cnn');
$redus -> rpush('username','gsl','lss','ykk');
$redis -> lRem('username','lss','1');
//对set集合的操作
$redis -> sadd('member','zhangsan','lisi','wangwu');
$redis -> srem('member','lisi');
//对hash类型的操作
$redis -> hset('sname','stdname','wangwu');
$redis -> hmset('mname',array('name'=>'lxq','age'=>21));