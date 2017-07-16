<?php

class UsersModel extends Model
{
    //查询用户列表数据
    public function userslist(){
        //准备sql语句
        $sql = "select * from users";
        //执行sql语句
        $rows = $this -> db -> fetchAll($sql);
        return $rows;
    }

    //添加新用户
    public function add($data){
        //准备sql
        $password = md5($data['password']);//将密码进行加密
        $sql = "insert into users(username,password,realname,sex,telephone)values('{$data['username']}','{$password}','{$data['realname']}','{$data['sex']}','{$data['telephone']}')";
        //执行sql
        $this -> db -> query($sql);
    }

    //修改数据回显
    public function editget($id){
        //准备sql
        $sql = "select * from users where user_id={$id}";
        //执行sql
        $row = $this -> db -> fetchRow($sql);
        return $row;
    }

    //修改用户数据
    public function edit($data){
        //准备sql
        $sql = "update users set username='{$data['username']}',realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}' where user_id={$data['id']}";
        //执行sql
        $this -> db -> query($sql);
    }

    //删除用户数据
    public function delete($id){
        //准备sql
        $sql = "delete from users where user_id={$id}";
        //执行sql
        $this -> db -> query($sql);
    }


}