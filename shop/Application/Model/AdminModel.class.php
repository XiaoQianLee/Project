<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/17
 * Time: 6:47
 */
class AdminModel extends Model
{
    //验证登录信息
    public function check($username,$password){
        //将用户输入的密码加密
        $password_in = md5($password);
        //准备sql
        $sql = "select * from members where username='{$username}' and password='{$password_in}' and is_admin=1";
        //执行sql
        $row = $this -> db -> fetchRow($sql);
        //判定是否查询到数据
        if(empty($row)){
            $this -> error = "用户名或密码错误，或不是管理员";
            return false;
        }else{
            return $row;
        }
    }

    //查询所有部门信息
    public function GroupGet(){
        //准备sql
        $sql = "select * from groups";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return $rows;
    }

    //查询所有员工信息
    public function MembersGet(){
        //准备sql
        $sql = "select * from members left JOIN groups on members.group_id = groups.group_id";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return $rows;
    }

    //添加员工信息
    public function insert($data){
        //将密码加密
        $password = md5($data['password']);
        //准备sql
        $sql  = "insert into members(photo,username,password,is_admin,realname,sex,telephone,group_id)values('{$data['photo']}','{$data['username']}','$password','{$data['is_admin']}','{$data['realname']}','{$data['sex']}','{$data['telephone']}','{$data['group_id']}')";
        //执行sql
        $this -> db -> query($sql);
    }

}