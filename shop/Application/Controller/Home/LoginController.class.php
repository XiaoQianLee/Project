<?php

class LoginController extends Controller
{
    //显示会员登录页面
    public function login(){
        //接收数据
        //处理数据
        //显示页面
        $this -> display('login');
    }

    //验证会员登录
    public function check(){
        //接收数据
        $username = $_POST['username'];
        $password = $_POST['password'];
        //处理数据
        $loginModel = new UsersModel();
        $result = $loginModel -> check($username,$password);
        //判定是否登录成功
        if($result === false){
            $this -> redirect('index.php?p=Home&c=Login&a=login',"登录失败！".$loginModel->getError(),2);
        }else{
            @session_start();//开启session
            $_SESSION['user_info'] = $result;
        }
        //显示页面
        $this -> redirect('index.php?p=Home&c=Ranking&a=index');
    }

    //退出登录功能
    public function logout(){
        //接收数据
        //处理数据
        //删除session中的信息
        @session_start();//开启session
        unset($_SESSION['user_info']);
        //显示页面
        $this->redirect('index.php?p=Home&c=Index&a=Index',"退出登录成功！",3);
    }
}