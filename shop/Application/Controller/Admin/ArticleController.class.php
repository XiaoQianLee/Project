<?php

class ArticleController extends PlatformController
{
    //添加活动
    public function add(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            //展示添加页面
            //接收数据
            //处理数据
            //显示页面
            $this -> display('add');
        }else{
            //活动数据添加
            //接收数据
            $data = $_POST;
            //处理数据
            //调用模型添加活动数据
            $articleModel = new ArticleModel();
            $articleModel -> add($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Article&a=index","发布活动成功，1秒后自动跳转",1);
        }
    }

    //显示活动列表
    public function index(){
        //接收数据
        //处理数据
        $articleModel = new ArticleModel();
        $result = $articleModel -> index();
        //分配数据到页面
        $this -> assign('article',$result['rows']);
        //分页
        $page = new Page($result['count'], $result['pageSize'], $result['page'], "?p=Admin&c=Article&a=index&page={page}", 3);
        $page = $page->myde_write();
        $this->assign('page',$page);
        //显示页面
        $this -> display('index');
    }

    //编辑活动内容
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//数据回显页面展示
            //接收数据
            $id = $_GET['id'];
            //处理数据
            //调用模型查询该活动详情
            $articleModel = new ArticleModel();
            $result = $articleModel -> editGet($id);
            //分配数据到页面
            $this -> assign('article',$result);
            //显示页面
            $this -> display('edit');
        }else{//数据修改
            //接收数据
            $data = $_POST;
            //处理数据
            $articleModel = new ArticleModel();
            $articleModel -> edit($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Article&a=index","编辑活动内容成功，1秒后自动跳转",1);
        }
    }

    //删除活动内容
    public function delete(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $articleModel = new ArticleModel();
        $result = $articleModel -> delete($id);
        if($result === false){//判定是否删除成功
            $this -> redirect("index.php?p=Admin&c=Article&a=index","删除活动失败！".$articleModel->getError(),2);
        }
        //显示页面
        $this -> redirect("index.php?p=Admin&c=Article&a=index","删除活动成功!1秒后自动跳转",1);
    }
}