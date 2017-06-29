<?php

class IndexController extends Controller
{
    //显示前台首页
    public function index(){
        //接收数据
        //处理数据
        //调用模型查询所有未过期的活动
        $articleModel = new ArticleModel();
        $rows = $articleModel -> ArticleGet();
        //分配数据到页面
        $this -> assign('article',$rows);
        //显示页面
        $this -> display('index');
    }

    //显示活动详情
    public function article(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $articleModel = new ArticleModel();
        $row = $articleModel -> editGet($id);
        //分配数据到页面
        $this -> assign('article',$row);
        //显示页面
        $this -> display('articleIndex');
    }

}