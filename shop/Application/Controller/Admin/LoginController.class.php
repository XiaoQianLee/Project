<?php

class LoginController extends Controller
{
    //展示后台登录页面
    public function login(){
        //接收数据
        //处理数据
        //显示页面
        $this -> display('login');
    }

    //提交登录请求 index.php?p=Admin&c=Login&a=check
    public function check(){
        //接收数据
        //判定验证码是否输入正确
        @session_start();//开启session
        $captcha = $_POST['captcha'];
        if(strtolower($captcha) != strtolower($_SESSION['random_code'])){
            $this -> redirect("index.php?p=Admin&c=Login&a=login","验证码输入错误，请重新输入",2);
        }
        $username = $_POST['username'];
        $password = $_POST['password'];
        //处理数据
        $AdminModel = new AdminModel();
        $result = $AdminModel -> check($username,$password);
        //判定是否登录成功
        if($result === false){
            $this -> redirect("index.php?p=Admin&c=Login&a=login","登录失败".$AdminModel->getError(),2);
        }else{
            $_SESSION['member_info'] = $result;
        }
        //显示页面
        $this -> redirect("index.php?p=Admin&c=Ranking&a=indexWaiter");
    }

    //退出登录功能
    public function logout(){
        //接收数据
        //处理数据
            //删除session中的信息
            @session_start();//开启session
            unset($_SESSION['member_info']);
        //显示页面
        $this->redirect('index.php?p=Home&c=Index&a=index',"退出登录成功！",2);
    }

}