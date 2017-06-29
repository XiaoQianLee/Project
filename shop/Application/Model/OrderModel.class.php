<?php

class OrderModel extends Model
{
    //会员进行预约,添加预约
    public function add($data){
        //准备sql
        $sql = "insert into orders(user_id,username,phone,user_realname,member_id,content,`date`)values('{$data['user_id']}','{$data['username']}','{$data['phone']}','{$data['user_realname']}','{$data['member_id']}','{$data['content']}','{$data['date']}')";
        //执行sql
        $this -> db -> query($sql);
    }

    //查询该会员的预约
    public function order($user_info){
        //准备sql
        $sql = "select * from orders where user_id='{$user_info['user_id']}'";
        //执行sql
        $result = $this -> db -> fetchAll($sql);
        foreach ($result as $k=>$v){
            $sqlc = "select realname from members where member_id={$result[$k]['member_id']}";
            $row = $this -> db -> fetchColumn($sqlc);
            $result[$k]['realname'] = $row;
        }
        return $result;
    }

    //后台查询会员预约
    public function OrderGet(){
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];//传入页码
        //获取总条数
        $c_sql = "select count(*) from orders";
        $count = $this->db->fetchColumn( $c_sql );
        //每页显示多少条
        $pageSize = 2;
        $start = ($page - 1) * $pageSize;//开始显示的条数

        //准备sql
        $sql = "select * from orders limit $start,$pageSize";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        foreach ($rows as $k=>$v){
            $sqlc = "select realname from members where member_id={$rows[$k]['member_id']}";//查询员工表中的员工姓名
            $results = $this -> db -> fetchColumn($sqlc);
            $rows[$k]['realname'] = $results;
        }
        return  [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
    }

    //查询特定预约信息
    public function Get($id){
        //准备sql
        $sql = "select * from orders where order_id={$id}";
        //执行sql
        $rows = $this -> db -> fetchRow($sql);
        //查询员工姓名
        $sqlc = "select realname from members where member_id={$rows['member_id']}";
        $results = $this -> db -> fetchColumn($sqlc);
        $rows['realname'] = $results;

        return $rows;
    }

    //处理预约成功信息
    public function succeed($data){
        //准备sql
        $sql = "update orders set status=1,reply='{$data['reply']}' where order_id={$data['order_id']}";
        //执行sql
        $this -> db -> query($sql);
    }

    //处理预约失败信息
    public function refuse($data){
        //准备sql
        $sql = "update orders set status=2,reply='{$data['reply']}' where order_id={$data['order_id']}";
        //执行sql
        $this -> db -> query($sql);
    }
}