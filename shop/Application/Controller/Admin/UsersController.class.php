<?php

class UsersController extends PlatformController
{
    //显示所有会员信息
    public function index(){
        //接收数据
        $condition = [];//组装条件
        //判定是否传入员工姓名
        if(!empty($_POST['realname'])){
            $condition[] = "realname like '%{$_POST['realname']}%'";
        }
        //判定是否传入员工性别
        if(!empty($_POST['sex'])){
            $condition[] = "sex like '%{$_POST['sex']}%'";
        }
        //判定是否传入员工号吗
        if(!empty($_POST['telephone'])){
            $condition[] = "telephone like '%{$_POST['telephone']}%'";
        }
        //处理数据
        //调用模型查询所有会员信息
        $usersModel = new UsersModel();
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $cond=implode(" and ",$condition);
        }else{
            $cond=isset($_GET['cond'])?$_GET['cond']:"";
        }
        $results = $usersModel -> index($cond);
        //分配数据到页面
        $this -> assign('users',$results['rows']);
        $cond=urlencode($cond);
        $page = new Page($results['count'], $results['pageSize'], $results['page'], "?p=Admin&c=Users&a=index&page={page}&cond={$cond}", 3);
        $page = $page->myde_write();
        $this->assign('page',$page);
        //显示页面
        $this -> display('index');
    }

    //添加会员的展示和数据添加
    public function add(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//判定是页面展示还是数据添加
            //页面展示
            //接收数据
            //处理数据
            //显示页面
            $this -> display('add');
        }else{
            //数据添加
            //接收数据
            $data = $_POST;
            $photo = $_FILES['photo'];
            //处理数据
            //判定是否有上传头像 如果没有就默认图片作为头像
            if($photo['error'] == 0){//文件上传成功
                //调用模型处理文件上传
                $uploadModel = new UploadModel();
                $result = $uploadModel -> upload($photo,'users/');
                //判定是否成功
                if($result === false){
                    $this -> redirect("index.php?p=Admin&c=Admin&a=edit",'上传图片时失败'.$this -> getError(),2);
                }else{
                    //调用模型制作缩略图
                    $imageModel = new ImageModel();
                    $photo_path = $imageModel -> thumb($result,100,100);
                    if($photo_path === false){
                        $this -> redirect("index.php?p=Admin&c=Admin&a=edit",'制作头像时失败'.$this -> getError(),2);
                    }else{
                        $data['photo'] = $photo_path;
                    }
                }
            }else{
                $data['photo'] = "member/photo_100x100.jpg";
            }
            //调用模型处理
            $usersModel = new UsersModel();
            $usersModel -> add($data);
            //显示页面
            $this -> redirect('index.php?p=Admin&c=Users&a=index');
        }
    }

    //编辑会员信息的展示和数据修改
    public function edit(){
        if ($_SERVER['REQUEST_METHOD'] == "GET") {//判定是页面展示还是数据修改
            //页面展示
            //接收数据
            $id = $_GET['id'];
            //处理数据
            //调用模型查询该会员的所有信息
            $usersModel = new UsersModel();
            $row = $usersModel -> editGet($id);
            //分配数据到页面
            $this -> assign('user',$row);
            //显示页面
            $this -> display('edit');
        } else {
            //数据修改
            //接收数据
            $data = $_POST;
            $photo = $_FILES['photo'];
            //处理数据
            if($photo['error'] == 0){//判定是否有上传头像
                //调用模型处理文件上传
                $uploadModel = new UploadModel();
                $result = $uploadModel -> upload($photo,'users/');
                //判定是否成功
                if($result === false){
                    $this -> redirect("index.php?p=Admin&c=Users&a=edit&id={$data['id']}",'上传图片时失败'.$this -> getError(),2);
                }else{
                    //调用模型制作缩略图
                    $imageModel = new ImageModel();
                    $photo_path = $imageModel -> thumb($result,100,100);
                    if($photo_path === false){
                        $this -> redirect("index.php?p=Admin&c=Users&a=edit&id={$data['id']}",'制作头像时失败'.$this -> getError(),2);
                    }else{
                        $data['photo'] = $photo_path;
                    }
                }
            }
            if(empty($data['password'])){
                $this -> redirect("index.php?p=Admin&c=Admin&a=edit&id={$data['id']}",'你还没有输入登录密码',2);
            }
            //调用模型修改数据
            $usersModel = new UsersModel();
            $usersModel -> edit($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Users&a=index","编辑会员信息成功，1秒后自动跳转",1);
        }
    }

    //删除会员信息
    public function delete(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $userModel = new UsersModel();
        $result = $userModel -> delete($id);
        if($result === false){
            $this -> redirect("index.php?p=Admin&c=Users&a=index","删除会员失败！".$userModel->getError(),2);
        }
        //显示页面
        $this -> redirect("index.php?p=Admin&c=Users&a=index","删除会员信息成功，1秒后自动跳转",1);
    }

    //会员充值
    public function recharge(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            //展示页面
            //接收数据
            $id = $_GET['id'];
            //处理数据
            $usersModel = new UsersModel();
            $result = $usersModel -> editGet($id);
            //分配数据到页面
            $this -> assign('user',$result);
            //显示页面
            $this -> display('recharge');
        }else{
            //数据修改
            //接收数据
            $data = $_POST;
            //处理数据
            $usersModel = new UsersModel();
            $usersModel -> recharge($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Users&a=index","会员账户充值成功，1秒后自动跳转",2);
        }
    }

    //交易记录查询
    public function record(){
        //接收数据
        $data = [];//准备条件
        if(!empty($_POST['type'])){
            $data[] = "type={$_POST['type']} - 1";
        }
        //处理数据
        //调用模型查询所有的充值记录
        $usersModel = new UsersModel();
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $data=implode(" and ",$data);
        }else{
            $data=isset($_GET['cond'])?$_GET['cond']:"";
        }
        $results = $usersModel -> record($data);
        //分配数据到页面
        $this -> assign('record',$results['rows']);
        $page = new Page($results['count'], $results['pageSize'], $results['page'], "?p=Admin&c=Users&a=record&page={page}", 3);
        $page = $page->myde_write();
        $this->assign('page',$page);
        //显示页面
        $this -> display('record');
    }

    //顾客消费
    public function expense(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//页面展示
            //接收数据
            $id = $_GET['id'];
            //处理数据
                //调用模型查询套餐数据
                $plansModel = new PlansModel();
                $results = $plansModel -> planGet();
                //分配数据到页面上
                $this -> assign('plan',$results);
                //查询该会员账户信息
                $usersModel = new UsersModel();
                $rows = $usersModel -> editGet($id);
                //分配数据到页面上
                $this -> assign('user',$rows);
                //查询所有员工信息
                $adminModel = new AdminModel();
                $admin = $adminModel -> memberGet();
                //分配数据到页面上
                $this -> assign('member',$admin);
                //查询该会员拥有的代金券
                $voucherModel = new VoucherModel();
                $row = $voucherModel -> voucherGet($id);
                //分配数据到页面上
                $this -> assign('voucher',$row);
            //显示页面
            $this -> display('expense');
        }else{//数据修改
            //接收数据
            $data = $_POST;
            //处理数据
            //调用模型处理数据
            $usersModel = new UsersModel();
            $result = $usersModel -> expense($data);
            if($result === false){
                $this -> redirect("index.php?p=Admin&c=Users&a=index","消费失败！".$usersModel->getError(),2);
            }
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Users&a=index","消费成功",1);
        }
    }

    //查询某会员交易明细
    public function detail(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        //调用模型查询该会员交易记录
        $userModel = new UsersModel();
        $rows = $userModel -> userDetail($id);
        //分配数据到页面
        $this -> assign('user',$rows);
        //显示页面
        $this -> display('detail');
    }

}