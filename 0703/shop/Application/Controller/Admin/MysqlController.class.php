<?php

class MysqlController extends Controller
{
    //显示实时账户和数据修改
    public function account(){
        //判定接收方式
        if($_SERVER['REQUEST_METHOD'] == "GET"){//显示实时账户
            //接收数据
            //处理数据
            $account = new MysqlModel();
            $rows = $account -> account();
            //分配数据到页面
            $this -> assign('account',$rows);
            //显示页面
            $this -> display('account');
        }else{//数据修改
            //接收数据
            $data = $_POST;
            //处理数据
            $account = new MysqlModel();
            $result = $account -> transfer($data);
            if($result === false){
                $this->redirect('index.php?p=Admin&c=Mysql&a=account','转账失败!'.$account->getError(),3);
            }
            //显示页面
            $this->redirect('index.php?p=Admin&c=Mysql&a=account','转账成功!',2);
        }
    }

}