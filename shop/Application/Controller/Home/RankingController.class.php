<?php

class RankingController extends Controller
{
    //展示充值消费排行榜页面
    public function index(){
        //接收数据
        //处理数据
        //调用模型消费榜前3的会员
        $usersModel = new UsersModel();
        $row = $usersModel -> rankingExpense();
        //分配数据到页面
        $this -> assign('expense',$row);
        //调用模型充值前3的会员
        $usersModel = new UsersModel();
        $rows = $usersModel -> rankingRecharge();
        //分配数据到页面
        $this -> assign('recharge',$rows);

        //显示页面
        $this -> display('index');
    }

    //显示服务之星排行榜
    public function indexWaiter(){
        //接收数据
        //处理数据
        //调用模型服务次数最多的员工
        $usersModel = new UsersModel();
        $results = $usersModel -> rankingWaiter();
        //分配数据到页面
        $this -> assign('waiter',$results);
        //显示页面
        $this -> display('indexWaiter');
    }
}