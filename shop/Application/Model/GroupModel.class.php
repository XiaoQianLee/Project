<?php

class GroupModel extends Model
{
    //查询所有部门信息
    public function index(){
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];//传入页码
        //获取总条数
        $c_sql = "select count(*) from groups";
        $count = $this->db->fetchColumn( $c_sql );
        //每页显示多少条
        $pageSize = 2;
        $start = ($page - 1) * $pageSize;//开始显示的条数
        //准备sql
        $sql = "select * from groups limit $start,$pageSize";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return  [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
    }

    //添加部门信息
    public function add($data){
        //准备sql
        $sql = "insert into groups(group_name)values('{$data['group_name']}')";
        //执行sql
        $this -> db -> query($sql);
    }

    //查询编辑的部门信息
    public function editGet($id){
        //准备sql
        $sql = "select * from groups where group_id={$id}";
        //执行sql
        $row = $this -> db -> fetchRow($sql);
        return $row;
    }

    //修改部门信息
    public function edit($data){
        //准备sql
        $sql = "update groups set group_name='{$data['group_name']}' where group_id='{$data['id']}'";
        //执行sql
        $this -> db -> query($sql);
    }

    //删除部门信息
    public function delete($id){
        //查询部门中是否有员工
        $sqlc = "select count(*) from members where group_id={$id}";
        $row = $this -> db -> fetchColumn($sqlc);
        if($row > 0){//如果部门中有员工
            $this -> error ="部门中还有员工，不能被删除";
            return false;
        }else{
            $sql = "delete from groups where group_id={$id}";
            $this -> db -> query($sql);
            return true;
        }
    }

    //部门信息分配
    public function groupGet(){
        //准备sql
        $sql = "select * from groups";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return $rows;
    }

}