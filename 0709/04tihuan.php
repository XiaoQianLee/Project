<?php
//中奖人号码
$strz = "13812345678";
$strl = "13999998888";
$strw = "15668682323";
$strzl = "13302583697";
$strt = "18856893214";

//隐藏号码 定义规则
$par = '/(\d{3})(\d{5})(\d{3})/';

$telephonez = preg_replace($par,'\1*****\3',$strz);
$telephonel = preg_replace($par,'\1*****\3',$strl);
$telephonew = preg_replace($par,'\1*****\3',$strw);
$telephonezl = preg_replace($par,'\1*****\3',$strzl);
$telephonet = preg_replace($par,'\1*****\3',$strt);

?>

<h2>中奖名单</h2>
<table border="1">
    <tr>
        <th>中奖人姓名</th>
        <th>中奖人电话</th>
    </tr>
    <tr>
        <th>张三</th>
        <th><?php echo $telephonez; ?></th>
    </tr>
    <tr>
        <th>李四</th>
        <th><?php echo $telephonel; ?></th>
    </tr>
    <tr>
        <th>王五</th>
        <th><?php echo $telephonew; ?></th>
    </tr>
    <tr>
        <th>赵六</th>
        <th><?php echo $telephonezl; ?></th>
    </tr>
    <tr>
        <th>田七</th>
        <th><?php echo $telephonet; ?></th>
    </tr>

</table>
