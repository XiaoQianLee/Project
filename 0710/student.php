<?php
//链接 数据库
$conn = mysqli_connect("192.168.0.101","root","111111","") or die("链接出错");
//php数据库引擎交互的字符集
mysqli_query($conn,"set names utf8");
//链接redis
$redis = new Redis();
$redis -> connect('192.168.0.101','6379');
//构造sql
$sql = "select * from student";
//执行sql，并返回结果集
$results = mysqli_query($conn,$sql);
//对资源型结果集进行整理
$arr = mysqli_fetch_assoc($results);

//从redis中读取数据
$time = $redis -> ttl('student');
if($time != (-2)){//从数据库查询
    $str = $redis -> hmget('student',array('name','num','age','class'));
    echo "学生姓名：".$str[0]."<br/>";
    echo "学生学号：".$str[1]."<br/>";
    echo "学生年龄：".$str[2]."<br/>";
    echo "学生班级：".$str[3]."<br/>";

}else{

    while($arr){
        echo "学生姓名：".$arr['name']."<br/>";
        echo "学生学号：".$arr['num']."<br/>";
        echo "学生年龄：".$arr['age']."<br/>";
        echo "学生班级：".$arr['class']."<br/>";
        //讲数据保存到redis中
        $redis -> hmset('student',array('name'=>"{$arr['name']}",'num'=>"{$arr['num']}",'age'=>"{$arr['age']}",'class'=>"{$arr['class']}"));
        $redis -> expire('student',60);
    }
}