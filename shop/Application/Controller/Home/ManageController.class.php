<?php

class ManageController extends VerifyController
{
    //显示会员操作界面
    public function manage(){
        //接收数据
        @session_start();//开启session
        //处理数据
        $user_info = $_SESSION['user_info'];
        //分配数据到视图
        $this -> assign('user',$user_info);
        //显示页面
        $this -> display('manage');
    }

    //添加预约页面显示、数据添加
    public function add(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//预约页面显示
            //接收数据
            @session_start();
            //处理数据
            $user_info = $_SESSION['user_info'];
            //分配数据到视图
            $this -> assign('user',$user_info);
            //调用模型查询所有员工
            $adminModel = new AdminModel();
            $results = $adminModel -> memberGet();
            //分配数据到页面
            $this -> assign('member',$results);
            //显示页面
            $this -> display('add');
        }else{//预约数据添加
            //接收数据
            $data = $_POST;
            //处理数据
            $orderModel = new OrderModel();
            $orderModel -> add($data);
            //显示页面
            $this -> redirect("index.php?p=Home&c=Manage&a=order","提交预约成功，等待处理",2);
        }
    }

    //显示我的预约
    public function order(){
        //接收数据
        @session_start();
        //处理数据
        $user_info = $_SESSION['user_info'];
        //调用模型查询该会员的预约
        $orderModel = new OrderModel();
        $result = $orderModel -> order($user_info);
//        var_dump($result);exit;
        //分配数据到页面
        $this -> assign('order',$result);
        //显示页面
        $this -> display('order');
    }

}