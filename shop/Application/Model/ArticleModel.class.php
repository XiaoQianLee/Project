<?php

class ArticleModel extends Model
{
    //添加活动数据
    public function add($data){
        //准备sql
        $start = strtotime($data['start']);
        $end = strtotime($data['end']);
        $sql = "insert into article(title,start,end,content)value('{$data['title']}','{$start}','{$end}','{$data['content']}')";
        //执行sql
        $this -> db -> query($sql);
    }

    //查询活动列表
    public function index(){
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];//传入页码
        //获取总条数
        $c_sql = "select count(*) from article";
        $count = $this->db->fetchColumn( $c_sql );
        //每页显示多少条
        $pageSize = 2;
        $start = ($page - 1) * $pageSize;//开始显示的条数
        //准备sql
        $sql = "select * from article limit $start,$pageSize";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return  [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
    }

    //编辑活动信息查询
    public function editGet($id){
        //准备sql
        $sql = "select * from article where article_id={$id}";
        //执行 sql
        $row = $this -> db -> fetchRow($sql);
        return $row;
    }

    //编辑活动内容数据
    public function edit($data){
        $start = strtotime($data['start']);
        $end = strtotime($data['end']);
        $time = time();
        //准备sql
        $sql = "update article set title='{$data['title']}',start='{$start}',end='{$end}',content='{$data['content']}' where article_id={$data['article_id']}";
        //执行sql
        $this -> db -> query($sql);
    }

    //删除活动内容
    public function delete($id){
        //查询活动是否过期
        $sql = "select `end` from article where article_id='{$id}'";
        $row = $this -> db -> fetchColumn($sql);
        $time = time();
        if($row >= $time){//判定活动是否过期
            $this -> error = "活动还未过期，暂时不能删除";
            return false;
        }else{
            $sqlc = "delete from article where article_id='{$id}'";
            $this -> db -> query($sqlc);
        }
    }

    //前台显示活动列表
    public function ArticleGet(){
        $time = time();
        $sql = "select * from article where `end`>=$time order by article_id desc limit 0,3";
        $rows = $this -> db -> fetchAll($sql);
        return $rows;

    }

}