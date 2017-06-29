<?php

class OrderController extends PlatformController
{
    //查询所有客户预约
    public function index(){
        //接收数据
        //处理数据
        //调用模型查询所有预约
        $orderModel = new OrderModel();
        $results = $orderModel -> OrderGet();
        //分配数据到页面
        $this -> assign('order',$results['rows']);
        //分页
        $page = new Page($results['count'], $results['pageSize'], $results['page'], "?p=Admin&c=Order&a=index&page={page}", 3);
        $page = $page->myde_write();
        $this->assign('page',$page);
        //显示页面
        $this -> display('index');
    }

    //预约成功，回复信息
    public function succeed(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//判定是显示页面还是数据修改
            //接收数据
            $id = $_GET['id'];
            //处理数据
            $orderModel = new OrderModel();
            $result = $orderModel -> Get($id);
            //分配数据到页面
            $this -> assign('order',$result);
            //显示页面
            $this -> display('reply');
        }else{//数据修改
            //接收数据
            $data = $_POST;
            //处理数据
            //调用模型处理数据
            $orderModel = new OrderModel();
            $orderModel -> succeed($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Order&a=index","处理成功！1秒后跳转",1);
        }
    }

    //预约失败，回复信息
    public function refuse(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//判定是显示页面还是数据修改
            //接收数据
            $id = $_GET['id'];
            //处理数据
            $orderModel = new OrderModel();
            $result = $orderModel -> Get($id);
            //分配数据到页面
            $this -> assign('order',$result);
            //显示页面
            $this -> display('refuseReply');
        }else{//数据修改
            //接收数据
            $data = $_POST;
            //处理数据
            //调用模型处理数据
            $orderModel = new OrderModel();
            $orderModel -> refuse($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Order&a=index","处理成功！1秒后跳转",1);
        }
    }
}