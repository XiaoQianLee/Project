<?php

class MysqlModel extends Model
{
    //查询账户实时余额
    public function account(){
        //准备sql
        $sql = "select * from account";
        //执行sql
        return $this -> db -> fetchAll($sql);
    }

    //账户转账
    public function transfer($data){
        //判定账户是否输入有误
        $result = $this -> db -> fetchColumn("select count(*) from account where userName='{$data['roll_out']}' or userName='{$data['shift_to']}'");
        if($result == 0) {
            $this->error = "未查询到该账户";
            return false;
        }
        $this -> db -> query("start transaction");//开启事物
        //修改数据
        $money = $this -> db -> fetchColumn("select userMoney from account where userName='{$data['roll_out']}'");//查询转出账户的余额
        //扣除转出账户的钱
        $result2 = $this -> db -> query("update account set userMoney=userMoney-{$data['rollout_money']} where userName='{$data['roll_out']}'");
        //添加转入账户的钱
        $result3 = $this -> db -> query("update account set userMoney=userMoney+{$data['rollout_money']} where userName='{$data['shift_to']}'");
        if($result2 == true && $result3 == true){
            if($data['rollout_money'] > ($money/2)){
                $this -> error = "转出金额超额！";
                $this -> db -> query("rollback");
                return false;
            }
            $this -> db -> query("commit");
            return true;
        }else{
            $this -> error = "转出转入过程中发生错误!";
            $this -> db -> query("rollback");
            return false;
        }
    }
}