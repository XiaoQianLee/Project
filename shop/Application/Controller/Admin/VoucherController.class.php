<?php

class VoucherController extends PlatformController
{
    //发放代金券
    public function add(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//判定是展示页面还是数据添加
            //展示页面
            //接收数据
            //处理数据
            //显示发放的会员
            $userModel = new UsersModel();
            $rows = $userModel -> UserGet();
            //分配数据到页面
            $this -> assign('user',$rows);
            //显示页面
            $this -> display('add');
        }else{
            //页面添加
            //接收数据
            $data = $_POST;
            //处理数据
            //调用模型生成代金券代码
            $voucherModel = new VoucherModel();
            $result = $voucherModel -> voucher();
            $data['code'] = $result;
            //调用模型添加代金券数据
            $voucherModel = new VoucherModel();
            $voucherModel -> add($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Voucher&a=index");
        }
    }

    //查询所有发放的代金券
    public function index(){
        //接收数据
        //处理数据
        //调用模型查询所有代金券
        $voucherModel = new VoucherModel();
        $results = $voucherModel -> index();
        //分配数据到页面
        $this -> assign('code',$results['rows']);
        //分页
        $page = new Page($results['count'], $results['pageSize'], $results['page'], "?p=Admin&c=Voucher&a=index&page={page}", 3);
        $page = $page->myde_write();
        $this->assign('page',$page);
        //显示页面
        $this -> display('index');
    }

    //编辑代金券
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//判定是展示页面还是数据修改
            //展示页面
            //接收数据
            $id = $_GET['id'];
            //处理数据
            $voucherModel = new VoucherModel();
            $result = $voucherModel -> editGet($id);
            //分配数据到页面
            $this -> assign('voucher',$result);
            //显示页面
            $this -> display('edit');
        }else{
            //数据修改
            //接收数据
            $data = $_POST;
            //处理数据
            //调用模型修改数据
            $voucherModel = new VoucherModel();
            $voucherModel -> edit($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Voucher&a=index","修改代金券成功，1秒后自动跳转",1);
        }
    }

    //删除代金券
    public function delete(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $voucherModel = new VoucherModel();
        $result = $voucherModel -> delete($id);
        //判定是否删除成功
        if($result === false){
            $this -> redirect("index.php?p=Admin&c=Voucher&a=index","删除代金券失败!".$voucherModel -> getError(),2);
        }
        //显示页面
        $this -> redirect("index.php?p=Admin&c=Voucher&a=index","删除代金券成功，1秒后自动跳转",1);
    }
}