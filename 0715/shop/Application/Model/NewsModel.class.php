<?php

class NewsModel extends Model
{
    //查询所有新闻
    public function getlist(){
        //准备sql
        $sql = "select * from new1 inner join new2";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return $rows;
    }

    //添加数据
    public function add($data){
        //准备sql
        $sql = "insert into new1(title)values('{$data['title']}')";
        $sqlc = "insert into new2(author,content)values('{$data['author']}','{$data['content']}')";
        //执行sql
        $this -> db -> query($sql);
        $this -> db -> query($sqlc);
    }

    //数据回显
    public function editget($id){
        $sql = "select * from new1 where new_id={$id}";
        $sqlc = "select * from new2 where new_id={$id}";
        $row[0] = $this -> db -> fetchRow($sql);
        $row[1] = $this -> db -> fetchRow($sqlc);
        return $row;
    }

    //数据修改
    public function edit($data){
        $sql = "update new1 set title='{$data['title']}' where new_id={$data['id']}";
        $sqlc = "update new2 set author='{$data['author']}',content='{$data['content']}' where new_id={$data['id']}";
        $this -> db -> query($sql);
        $this -> db -> query($sqlc);
    }

    //数据删除
    public function delete($id){
        $sql = "delete from new1 where new_id={$id}";
        $sqlc = "delete from new2 where new_id={$id}";
        $this -> db -> query($sql);
        $this -> db -> query($sqlc);
    }
}