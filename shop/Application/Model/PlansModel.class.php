<?php

class PlansModel extends Model
{
    //添加套餐数据
    public function add($data){
        //准备sql
        $sql = "insert into plans(name,des,money,status)values('{$data['name']}','{$data['des']}','{$data['money']}','{$data['status']}')";
        //执行sql
        $this -> db -> query($sql);
    }

    //查询所有套餐数据
    public function index(){
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];//传入页码
        //获取总条数
        $c_sql = "select count(*) from plans";
        $count = $this->db->fetchColumn( $c_sql );
        //每页显示多少条
        $pageSize = 2;
        $start = ($page - 1) * $pageSize;//开始显示的条数
        //准备sql
        $sql = "select * from plans limit $start,$pageSize";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return  [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
    }

    //查询编辑的套餐数据进行回显
    public function editGet($id){
        //准备sql
        $sql = "select * from plans where plan_id={$id}";
        //执行sql
        $row = $this -> db -> fetchRow($sql);
        return $row;
    }

    //修改套餐内容数据
    public function edit($data){
        //准备sql
        $sql = "update plans set name='{$data['name']}',des='{$data['des']}',money='{$data['money']}',status='{$data['status']}' where plan_id='{$data['id']}'";
        //执行sql
        $this -> db -> query($sql);
    }

    //删除套餐数据
    public function delete($id){
        //准备sql
        $sql = "delete from plans where plan_id={$id}";
        //执行sql
        $this -> db -> query($sql);
    }

    //回显套餐信息
    public function planGet(){
        //准备sql
        $sql = "select * from plans";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return $rows;
    }
}