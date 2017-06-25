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
        //准备sql
        $sql = "select * from plans";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return $rows;
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
}