<?php

class UsersModel extends Model
{
    //查询所有会员数据
    public function index($condition = []){
        //准备sql
        $where = "";//准备where条件
        if(!empty($condition)){
            $where = " where ".implode(" and ",$condition);
        }
        //准备sql
        $sql = "select * from users".$where;
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return $rows;
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
        //准备sql
        $sql = "delete from users where user_id={$id}";
        //执行sql
    }

}