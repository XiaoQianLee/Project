<?php

class VoucherModel extends Model
{
    //生成代金券代码
    public function voucher(){
        //生成字符串
        $string = "qwertyuipasdfghjkzxcvbnmQWERTYUPASDFGHJKLZXCVBNM";
        //打乱字符串
        $string = str_shuffle($string);
        //截取字符串,生成代码
        $voucher = "VC".substr($string,0,6);
        return $voucher;
    }

    //添加代金券
    public function add($data){
        //准备sql
        $sql = "insert into codes(code,user_id,voucher_money)values('{$data['code']}','{$data['user_id']}','{$data['voucher_money']}')";
        //执行sql
        $this -> db -> query($sql);
    }

    //查询所有已经发放的代金券
    public function index(){
        $page = empty( $_GET['page'] ) ? 1 : $_GET['page'];//传入页码
        //获取总条数
        $c_sql = "select count(*) from codes";
        $count = $this->db->fetchColumn( $c_sql );
        //每页显示多少条
        $pageSize = 2;
        $start = ($page - 1) * $pageSize;//开始显示的条数

        //准备sql
        $sql = "select * from codes left JOIN users on codes.user_id = users.user_id limit $start,$pageSize";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return  [ 'rows' => $rows, 'page' => $page, 'count' => $count, 'pageSize' => $pageSize ];
    }

    //查询编辑中的代金券
    public function editGet($id){
        //准备sql
        $sql = "select * from codes left JOIN users on codes.user_id = users.user_id where code_id={$id}";
        //执行sql
        $row = $this -> db -> fetchRow($sql);
        return $row;
    }

    //修改代金券数据
    public function edit($data){
        //准备sql
        $sql = "update codes set voucher_money='{$data['voucher_money']}' where code_id='{$data['code_id']}'";
        //执行sql
        $this -> db -> query($sql);
    }

    //删除代金卷
    public function delete($id){
        //判定代金卷是否有使用
        $sql = "select status from codes where code_id={$id}";
        $row = $this -> db -> fetchColumn($sql);
        if($row == 0){
            $this -> error = "该代金券还未使用，不能删除";
            return false;
        }else{
            //准备sql
            $sqlc = "delete from codes where code_id={$id}";
            //执行sql
            $this -> db -> query($sql);
            return true;
        }
    }

    //查询会员拥有的代金券
    public function voucherGet($id){
        //准备sql
        $sql = "select * from codes where user_id={$id} and status=0";
        //执行sql
        $rows = $this -> db -> fetchAll($sql);
        return $rows;
    }
}