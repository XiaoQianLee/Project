<?php

class MysqlController extends Controller
{
    //查询所有比赛
    public function Match(){
        //接收数据
        //处理数据
        $mysql = new MysqlModel();
        $row = $mysql -> match();
        //分配数据到页面
        $this -> assign('match',$row);
        //显示页面
        $this -> display('match');
    }

    //查询运动员信息
    public function player(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $mysql = new MysqlModel();
        $row = $mysql -> player($id);
        //分配数据到页面
        $this -> assign('play',$row);
        //显示页面
        $this -> display('player');
    }

    //查看运动相关的比赛
    public function studentMatch(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $mysql = new MysqlModel();
        $row = $mysql -> playMatch($id);
        //分配数据到页面
        $this -> assign('play',$row);
        //显示页面
        $this -> display('playMatch');
    }
}