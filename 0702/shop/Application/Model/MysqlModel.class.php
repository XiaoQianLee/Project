<?php

class MysqlModel extends Model
{
    //查询所有比赛记录
    public function match(){
        //准备sql
        $sql = "select `match`.id,s1.`name` as hostTeam,`match`.result,s2.`name` as guestTeam,`match`.time,`match`.play1 as team1,`match`.play2 as team2 from student as s1 inner join `match` on s1.id=`match`.play1 inner join student as s2 on s2.id=`match`.play2";
        //执行sql，并返回结果
        return $this -> db -> fetchAll($sql);
    }

    //查询运动员信息
    public function player($id){
        //准备sql
        $sql = "select * from student where id={$id}";
        $row = $this -> db -> fetchRow($sql);

        $sqlc = "select * from `match` where play1={$id} or play2={$id}";
        $row['screenings'] = $this -> db -> fetchColumn($sqlc);
        return $row;
    }

    //查询运动参与的比赛
    public function playMatch($id){
        //准备sql
        $sql = "select `match`.id,s1.`name` as hostTeam,`match`.result,s2.`name` as guestTeam,`match`.time,`match`.play1 as team1,`match`.play2 as team2 from student as s1 inner join `match` on s1.id=`match`.play1 inner join student as s2 on s2.id=`match`.play2 where play1={$id} or play2={$id};";
        //执行sql，并返回结果
        return $this -> db -> fetchAll($sql);
    }
}