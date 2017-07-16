<?php

class AdminController extends Controller
{
    //查询所有新闻
    public function index(){
        //调用模型处理数据
        $newsModel = new NewsModel();
        $rows = $newsModel -> getlist();
        //分配数据到页面
        $this -> assign('news',$rows);
        //显示页面
        $this -> display('list');
    }

    //添加页面展示和数据添加
    public function add(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//页面展示
            //显示页面
            $this -> display('add');
        }else{//数据添加
            //接收数据
            $data = $_POST;
            //处理数据
            $newsModel = new NewsModel();
            $newsModel -> add($data);
            //显示页面
            $this -> redirect('index.php?p=Admin&c=Admin&a=index');
        }
    }

    //修改数据页面显示和数据修改
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//页面展示
            //接收数据
            $id = $_GET['id'];
            //处理数据
            $newsModel = new NewsModel();
            $row = $newsModel -> editget($id);
            //分配数据到页面
            $this -> assign('new',$row);
            //显示页面
            $this -> display('edit');
        }else{//数据修改
            //接收数据
            $data = $_POST;
            //处理数据
            $newsModel = new NewsModel();
            $newsModel -> edit($data);
            //显示页面
            $this -> redirect('index.php?p=Admin&c=Admin&a=index');
        }
    }

    //数据删除
    public function delete(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $newsModel = new NewsModel();
        $newsModel -> delete($id);
        //显示页面
        $this -> redirect('index.php?p=Admin&c=Admin&a=index');
    }
}