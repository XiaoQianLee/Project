<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 9:42
 */
class VerifyController extends Controller
{
    /**
     * 初始化
     */
    public function __construct(){
        if($this->checkLogin() === false){
            $this->redirect('index.php?p=Home&c=Index&a=Index',"你还没有登录！请登录后再操作！",3);
        }
    }

    /**
     * 验证是否登录 失败返回false
     */
    private function checkLogin(){
        //使用session中的用户信息来判断是否登录
        @session_start();
        if(!isset($_SESSION['user_info'])){
            //没有登录信息，应该跳转到登录页面
            return false;
        }
    }
}