<?php

class PlansController extends PlatformController
{
    //套餐管理查询所有套餐
    public function index(){
        //接收数据
        //处理数据
        $plansModel = new PlansModel();
        $results = $plansModel -> index();
        //分配数据到页面
        $this -> assign('plans',$results);
        //显示页面
        $this ->display('index');
    }

    //添加套餐
    public function add(){
        //判定是展示页面还是数据添加
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            //展示添加页面
            //接收数据
            //处理数据
            //显示页面
            $this -> display('add');
        }else{
            //添加数据
            //接收数据
            $data = $_POST;
            //处理数据
            $plansModel = new PlansModel();
            $plansModel -> add($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Plans&a=index","添加套餐成功，1秒后自动跳转",1);
        }
    }

    //编辑套餐信息
    public function edit(){
        //判定是展示编辑页面还是编辑数据
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            //展示编辑页面
            //接收数据
            $id = $_GET['id'];
            //处理数据
            //调用模型查询该套餐的数据
            $plansModel = new PlansModel();
            $row = $plansModel -> editGet($id);
            //分配数据到页面
            $this -> assign('plan',$row);
            //显示页面
            $this -> display('edit');
        }else{
            //编辑数据
            //接收数据
            $data = $_POST;
            //处理数据
            $plansModel = new PlansModel();
            $plansModel -> edit($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Plans&a=index","编辑套餐内容成功，1秒后跳转",1);
        }
    }

    //删除套餐信息
    public function delete(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        //调用模型删除数据
        $plansModel = new PlansModel();
        $plansModel -> delete($id);
        //显示页面
        $this -> redirect("index.php?p=Admin&c=Plans&a=index","删除套餐成功，1秒后跳转",1);
    }
}