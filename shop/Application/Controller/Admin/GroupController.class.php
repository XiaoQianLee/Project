<?php

class GroupController extends PlatformController
{
    //查询所有部门信息
    public function index(){
        //接收数据
        //处理数据
        $groupModel = new GroupModel();
        $group = $groupModel -> index();
        //分配数据到页面
        $this -> assign('group',$group);
        //显示页面
        $this->display('index');
    }

    //添加部门信息
    public function add(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//判定接收方式
            //展示添加页面
            //接收数据
            //处理数据
            //显示页面
            $this->display('add');
        }else{
            //部门数据添加
            //接收数据
            $data = $_POST;
            //处理数据
            $groupModel = new GroupModel();
            $groupModel -> add($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Group&a=index","添加新部门成功,2秒后自动跳转",2);
        }
    }

    //编辑部门信息
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            //展示显示页面
            //接收数据
            $id = $_GET['id'];
            //处理数据
            $groupModel = new GroupModel();
            $row = $groupModel -> editGet($id);
            //分配数据到页面
            $this -> assign('group',$row);
            //显示页面
            $this -> display('edit');
        }else{
            //编辑数据
            //接收数据
            $data = $_POST;
            //处理数据
            $groupModel = new GroupModel();
            $groupModel -> edit($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Group&a=index","编辑部门信息成功，1秒够跳转",1);
        }
    }

    //删除部门信息
    public function delete(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $groupModel = new GroupModel();
        $result = $groupModel -> delete($id);
        //显示页面
        if($result === false){//判断是否删除成功
            $this->redirect("index.php?p=Admin&c=Group&a=index","删除失败".$groupModel->getError(),2);
        }
    }
}