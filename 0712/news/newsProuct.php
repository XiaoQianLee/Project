<?php
//引入db类
@require "./DB.class.php";
//实例化db类
$db = DB::getInstance();
//查询所有新闻
$rows = $db -> fetchAll("select * from news");
//循环生成所有新闻详情的静态页面
foreach ($rows as $row){
    //判定是否已经存在静态页面
    if(!file_exists("./content".$row['id'].".html")){
        //读取模板内容
        $str = file_get_contents("./news.tpl");
        //将内容替换
        $readin = ["{{title}}","{{time}}","{{content}}"];
        $replace = [$row['title'],$row['time'],$row['content']];
        $str = str_replace($readin,$replace,$str);
        //生成静态页面
        file_put_contents("./news".$row['id'].".html",$str);
    }else{
        $time = $row['time'];
        //获取文件的最后修改时间
        $timeEnd = filectime("./news".$row['id'].".html");
        $time = strtotime($time);//将时间戳转化为整形
        if($timeEnd < $time){
            //读取模板内容
            $str = file_get_contents("./news.tpl");
            //将内容替换
            $readin = ["{{title}}","{{time}}","{{content}}"];
            $replace = [$row['title'],$row['time'],$row['content']];
            $str = str_replace($readin,$replace,$str);
            //生成静态页面
            file_put_contents("./news".$row['id'].".html",$str);
        }
    }
}
