<?php

class AdminController extends PlatformController
{
    //显示员工信息管理列表[后台首页] index.php?p=Admin&c=Admin&a=index
    public function index(){
        //接收数据
        //处理数据
            //调用模型查询部门信息
            $AdminModel = new AdminModel();
            $group = $AdminModel -> GroupGet();
            //分配数据到页面
            $this -> assign('group',$group);
            //调用模型查询所有员工信息
            $adminModel = new AdminModel();
            $members = $AdminModel -> MembersGet();
            //分配数据到页面
            $this -> assign('members',$members);
        //显示页面
        $this -> display('index');
    }

    //员工添加的页面展示和数据添加 index.php?p=Admin&c=Admin&a=add
    public function add(){
        //判定数据接收方式判定功能
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            //添加页面的展示功能
            //接收数据
            //处理数据
                //调用模型查询部门信息
                $AdminModel = new AdminModel();
                $group = $AdminModel -> GroupGet();
                //分配数据到页面
                $this -> assign('group',$group);
            //显示页面
            $this -> display('add');
        }else{
            //添加页面的数据添加功能
            //接收数据
            $data = $_POST;
            $photo = $_FILES['photo'];
            //处理数据
            //判定是否有上传头像 如果没有就默认图片作为头像
            if($photo['error'] == 0){//文件上传成功
                //调用模型处理文件上传
                $uploadModel = new UploadModel();
                $result = $uploadModel -> upload($photo,'member/');
                //判定是否成功
                if($result === false){
                    $this -> redirect("index.php?p=Admin&c=Admin&a=add",'上传图片时失败'.$this -> getError(),2);
                }else{
                    //调用模型制作缩略图
                    $imageModel = new ImageModel();
                    $photo_path = $imageModel -> thumb($result,100,100);
                    if($photo_path === false){
                        $this -> redirect("index.php?p=Admin&c=Admin&a=add",'制作头像时失败'.$this -> getError(),2);
                    }else{
                        $data['photo'] = $photo_path;
                    }
                }

            }else{
                $data['photo'] = "member/photo.jpg";
            }
            //调用模型处理添加数据
            $adminModel = new AdminModel();
            $adminModel -> insert($data);
            //显示页面
            $this -> redirect('index.php?p=Admin&c=Admin&a=index');
        }
    }



}