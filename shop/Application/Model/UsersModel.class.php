<?php

class UsersModel extends Model
{
    //查询所有会员数据
    public function index($condition = []){
        //准备sql
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];//传入页码

        $where = "";//准备where条件
        if(!empty($condition)){
            $where = " where ".$condition;
        }
        //获取总条数
        $c_sql = "select count(*) from users " . $where;
        $count = $this->db->fetchColumn( $c_sql );
        //每页显示多少条
        $pageSize = 2;
        $start = ($page - 1) * $pageSize;//开始显示的条数


        //准备sql
        $sql = "select * from users".$where." limit $start,$pageSize";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);

        return  [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
    }

    //添加会员信息
    public function add($data){
        //将登录密码加密
        $password = md5($data['password']);
        //准备sql
        $sql = "insert into users(username,password,realname,sex,telephone,remark,photo)values('{$data['username']}','{$password}','{$data['realname']}','{$data['sex']}','{$data['telephone']}','{$data['remark']}','{$data['photo']}')";
        //执行sql
        $this -> db -> query($sql);
    }

    //查询一位会员的详细信息
    public function editGet($id){
        //准备sql
        $sql = "select * from users where user_id={$id}";
        //执行sql
        $row = $this -> db -> fetchRow($sql);
        return $row;
    }

    //修改会员信息
    public function edit($data){
        //将登录密码加密
        $password = md5($data['password']);
        //判断是否有上传图片
        if(isset($data['photo'])){
            $sql = "update users set username='{$data['username']}',password='{$password}',realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}',remark='{$data['remark']}',photo='{$data['photo']}' where user_id='{$data['id']}'";
        }else{
            $sql = "update users set username='{$data['username']}',password='{$password}',realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}',remark='{$data['remark']}' where user_id='{$data['id']}'";
        }
        //执行sql
        $this -> db -> query($sql);
    }

   //删除会员信息
    public function delete($id){
        //查询会员是否有交易流水
        $sqlc = "select count(*) from histories where user_id={$id}";
        $row = $this -> db -> fetchColumn($sqlc);
        if($row > 0){
            $this -> error = "该会员暂时无法删除！";
            return false;
        }else{
            //准备sql
            $sql = "delete from users where user_id={$id}";
            //执行sql
            $this -> db -> query($sql);
            return true;
        }



    }

    //验证会员登录信息
    public function check($username,$password){
        //将传入的密码加密
        $password_in = md5($password);
        //准备sql
        $sql = "select * from users where username='{$username}' and password='{$password_in}'";
        //执行sql
        $row = $this -> db -> fetchRow($sql);
        //判定是否验证成功
        if(empty($row)){
            $this -> error = "用户名或密码错误，请重新输入";
            return false;
        }else{
            return $row;
        }

    }

    //会员账户充值
    public function recharge($data){
        $money = str_replace(".00","",$data['money']);
        $money_in = $money + $data['amount'];
        //账户充值
        //准备sql
        if($data['amount'] <= 500){
            $sql = "update users set money='$money_in' where user_id='{$data['user_id']}'";
        }elseif($data['amount'] > 500 && $data['amount'] <= 1000){
            $money_in_db = $money_in + 100;
            $sql = "update users set money='{$money_in_db}' where user_id='{$data['user_id']}'";
        }elseif($data['amount'] > 1000 && $data['amount'] <= 5000){
            $money_in_db = $money_in + 300;
            $sql = "update users set money='{$money_in_db}' where user_id='{$data['user_id']}'";
        }elseif($data['amount'] > 5000){
            $money_in_db = $money_in + 1000;
            $sql = "update users set money='{$money_in_db}',is_vip=1 where user_id='{$data['user_id']}'";
        }
        //执行sql
        $this -> db -> query($sql);
        //充值记录
        $sqlc = "select money from users where user_id='{$data['user_id']}'";//查询会员账户余额
        $row = $this -> db -> fetchColumn($sqlc);
        //准备sql
        $sql = "insert into histories(user_id,amount,remainder)values('{$data['user_id']}','{$data['amount']}','{$row}')";
        //执行sql
        $this -> db -> query($sql);
    }

    //查询所有充值记录
    public function record($data = []){
        //准备sql
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];//传入页码

        $where = "";//准备where条件
        if(!empty($data)){
            $where = " where ".$data;
        }
        //获取总条数
        $c_sql = "select count(*) from histories " . $where;
        $count = $this->db->fetchColumn( $c_sql );
        //每页显示多少条
        $pageSize = 5;
        $start = ($page - 1) * $pageSize;//开始显示的条数
        //准备sql
        $sql = "select * from histories".$where." limit $start,$pageSize";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);

        foreach ($rows as $k=>$v){
            //查询会员账户
            $sqlc = "select realname from users where user_id={$rows[$k]['user_id']}";
            $username = $this -> db -> fetchColumn($sqlc);
            $rows[$k]['username'] = $username;
            //查询员工姓名
            if(!empty($rows[$k]['member_id'])){
                $sqlx = "select realname from members where member_id={$rows[$k]['member_id']}";
                $realname = $this -> db -> fetchColumn($sqlx);
                $rows[$k]['realname'] = $realname;
            }
        }
        return  [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
    }

    //会员账户消费
    public function expense($data){
        //查看消费的套餐
        $sqlc = "select * from plans where plan_id={$data['plan_id']}";
        $plan = $this->db->fetchRow($sqlc);
        //查询是否是vip
        $sqly= "select is_vip from users where user_id={$data['user_id']}";
        $vip = $this -> db -> fetchColumn($sqly);
        if(!empty($data['code_id'])){//使用代金券
            //查询代金券金额
            $sql = "select voucher_money from codes where code_id={$data['code_id']}";
            $code = $this->db->fetchColumn($sql);
            if($plan['money'] > $code){//消费金额大于代金卷金额
                if($vip == 1){
                    $money_expense = ($plan['money'] - $code) * 0.5;
                }else{
                    $money_expense = $plan['money'] - $code; //消费的金额
                }
                if($data['money'] < $money_expense){//如果余额小于消费金额
                    $this->error = "账户余额不足，请充值";
                    return false;
                }
                $money = $data['money'] - $money_expense;//消费后的账户余额
                //会员账户余额发生改变
                $sql = "update users set money='{$money}' where user_id={$data['user_id']}";
                $this->db->query($sql);
                //代金券使用状态发生改变
                $sqlc = "update codes set `status`=1 where code_id={$data['code_id']}";
                $this->db->query($sqlc);
                //消费记录增加
                $sqlx = "insert into histories(user_id,member_id,`type`,amount,content,remainder)VALUES ('{$data['user_id']}','{$data['member_id']}',1,'{$plan['money']}','{$plan['name']}','{$money}')";
                $this->db->query($sqlx);
                return true;
            }else{//消费金额小于代金卷金额
                //代金券使用状态发生改变
                $sqlc = "update codes set `status`=1 where code_id={$data['code_id']}";
                $this->db->query($sqlc);
                //消费记录增加
                $sqlx = "insert into histories(user_id,member_id,`type`,amount,content,remainder)VALUES ('{$data['user_id']}','{$data['member_id']}',1,'{$plan['money']}','{$plan['name']}','{$data['money']}')";
                $this->db->query($sqlx);
                return true;
            }
        }else{//不使用代金券
            if($data['money'] < $plan['money']){//账户余额小于消费金额
                $this -> error = "账户余额不足，请充值";
                return false;
            }
            if($vip == 1){
                $plan['money'] = $plan['money'] * 0.5;
            }
            //余额大于消费金额
            $money = $data['money'] - $plan['money'];//消费后的账户余额
            //会员账户余额发生改变
            $sql = "update users set money='{$money}' where user_id={$data['user_id']}";
            $this->db->query($sql);
            //消费记录增加
            $sqlx = "insert into histories(user_id,member_id,`type`,amount,content,remainder)values('{$data['user_id']}','{$data['member_id']}',1,'{$plan['money']}','{$plan['name']}','{$money}')";
            $this -> db -> query($sqlx);
            return true;
        }
    }

    //查询消费最多的3名会员
    public function rankingExpense(){
        //准备sql
        $sql = "select user_id ,sum(amount) as money from histories where type=1 group by user_id order by money desc limit 0,3";
        //执行sql
        $row = $this -> db -> fetchAll($sql);
        foreach ($row as $k=>$v){
            $sqlc = "select realname from users where user_id={$row[$k]['user_id']}";
            $realname = $this -> db -> fetchColumn($sqlc);
            $row[$k]['realname'] = $realname;
        }
        return $row;
    }

    //查询充值最多的3名会员
    public function rankingRecharge(){
        //准备sql
        $sql = "select user_id ,sum(amount) as money from histories where type=0 group by user_id order by money desc limit 0,3";
        //执行sql
        $row = $this -> db -> fetchAll($sql);
        foreach ($row as $k=>$v){
            $sqlc = "select realname from users where user_id={$row[$k]['user_id']}";
            $realname = $this -> db -> fetchColumn($sqlc);
            $row[$k]['realname'] = $realname;
        }
        return $row;
    }

    //查询服务次数最多的3名员工
    public function rankingWaiter(){
        //准备sql
        $sql = "select member_id ,count(*) as count from histories where type=1 group by member_id order by count desc limit 0,3";
        //执行sql
        $row = $this -> db -> fetchAll($sql);
        foreach ($row as $k=>$v){
            $sqlc = "select realname from members where member_id={$row[$k]['member_id']}";
            $realname = $this -> db -> fetchColumn($sqlc);
            $row[$k]['realname'] = $realname;
        }
        return $row;
    }

    //发放代金券时显示发放的会员
    public function UserGet(){
        //准备sql
        $sql = "select * from users";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return $rows;
    }

    //查询该会员交易记录
    public function userDetail($id){
        //准备sql
        $sql = "select * from histories where user_id={$id}";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        foreach ($rows as $k=>$v) {
            //查询员工姓名
            if (!empty($rows[$k]['member_id'])) {
                $sqlx = "select realname from members where member_id={$rows[$k]['member_id']}";
                $realname = $this->db->fetchColumn($sqlx);
                $rows[$k]['realname'] = $realname;
            }
        }
        return $rows;
    }

}