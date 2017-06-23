<?php

/**
 * 平台统一验证控制器
 * 以后需要验证登录的控制器都需要继承该控制器
 */
class PlatformController extends Controller
{
    /**
     * 初始化
     */
    public function __construct(){
        if($this->checkLogin() === false){
            $this->redirect('index.php?p=Admin&c=Login&a=login',"你还没有登录！请登录再访问！",3);
        }
    }


    /**
     * 验证是否登录 失败返回false
     */
    private function checkLogin(){
        //使用session中的用户信息来判断是否登录
        @session_start();
        if(!isset($_SESSION['member_info'])){
            //没有登录信息，应该跳转到登录页面
            return false;
        }
    }
}