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
        $results = $usersModel -> index($condition);
        //分配数据到页面
        $this -> assign('users',$results);
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
        $userModel -> delete($id);
        //显示页面
        $this -> redirect("index.php?p=Admin&c=Users&a=index","删除会员信息成功，1秒后自动跳转",1);
    }
}