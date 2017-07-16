<?php
//声明字符串
$str="我...我是是..一个个...帅帅帅帅...哥!";
//声明正则表达式
$par = '/\./';
//去掉所有的省略号
$str_replace = preg_replace($par,'',$str);

//匹配结巴程序
$pars = '/(.)\1+/u';
//替换字符串
$strs = preg_replace($pars,'\1',$str_replace);
//打印
echo $strs;
