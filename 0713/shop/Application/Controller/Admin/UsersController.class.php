<?php

class UsersController extends Controller
{
    //显示用户列表
    public function userlist(){
        //处理数据
        $userModel = new UsersModel();
        $rows = $userModel -> userslist();
        //分配数据到页面
        $this -> assign('users',$rows);
        //显示页面
        $this -> display('list');
    }

    //添加页面展示和数据添加
    public function add(){
        //判定页面展示还是数据添加
        if($_SERVER['REQUEST_METHOD'] == "GET"){//页面展示
            //显示页面
            $this -> display('add');
        }else{//数据添加
            //接收数据
            $data = $_POST;
            //处理数据
            $userModel = new UsersModel();
            $userModel -> add($data);
            //显示页面
            $this -> redirect('index.php?p=Admin&c=Users&a=userlist','添加新用户成功！',1);
        }
    }

    //修改页面展示和数据修改
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//页面展示
            //接收数据
            $id = $_GET['id'];
            //处理数据
            $userModel = new UsersModel();
            $row = $userModel -> editget($id);
            //分配数据到页面
            $this -> assign('user',$row);
            //显示页面
            $this -> display('edit');
        }else{//数据修改
            //接收数据
            $data = $_POST;
            //处理数据
            $userModel = new UsersModel();
            $userModel -> edit($data);
            //显示页面
            $this -> redirect('index.php?p=Admin&c=Users&a=userlist','修改用户信息成功!',1);
        }
    }

    //删除该用户
    public function delete(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $userModel = new UsersModel();
        $userModel -> delete($id);
        //显示页面
        $this -> redirect('index.php?p=Admin&c=Users&a=userlist','删除用户成功!',1);
    }
}