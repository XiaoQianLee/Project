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

    //查询所有员工信息
    public function MembersGet($condition = []){
        //准备sql
        $where = "";//准备where条件
        if(!empty($condition)){
            $where = " where ".implode(" and ",$condition);
        }
        $sql = "select * from members left JOIN groups on members.group_id = groups.group_id ".$where;
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

    //查询员工编辑信息
    public function EditGet($id){
        //准备sql
        $sql = "select * from members where member_id=$id";
        //执行sql
        $row = $this -> db -> fetchRow($sql);
        return $row;
    }

    //编辑员工信息
    public function edit($data){
        //将传过来的密码进行加密
        $password = md5($data['password']);
        //准备sql
        //判定是否有上传头像
        if(isset($data['photo'])){
            $sql = "update members set photo='{$data['photo']}',username='{$data['username']}',password='$password',is_admin='{$data['is_admin']}',realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}',group_id='{$data['group_id']}' where member_id='{$data['id']}' ";
        }else{
            $sql = "update members set username='{$data['username']}',password='$password',is_admin='{$data['is_admin']}',realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}',group_id='{$data['group_id']}' where member_id='{$data['id']}' ";
        }
        //执行sql
        $this -> db -> query($sql);
    }

    //删除员工信息
    public function delete($id){
        
    }

}