<?php

class AdminController extends PlatformController
{
    //显示员工信息管理列表[后台首页] index.php?p=Admin&c=Admin&a=index
    public function index(){
        //接收数据
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
            //调用模型查询所有员工信息
            $adminModel = new AdminModel();
            if($_SERVER['REQUEST_METHOD']=="POST"){
            $cond=implode(" and ",$condition);
            }else{
                $cond=isset($_GET['cond'])?$_GET['cond']:"";
            }
            $members = $adminModel -> MembersGet($cond);
            //分配数据到页面
            $this -> assign('members',$members['rows']);
            //分页
            $cond=urlencode($cond);
            $page = new Page($members['count'], $members['pageSize'], $members['page'], "?p=Admin&c=Admin&a=index&page={page}&cond={$cond}", 3);

        $page = $page->myde_write();
        $this->assign('page',$page);
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
                $groupModel = new GroupModel();
                $group = $groupModel -> groupGet();
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
            //调用模型处理添加数据
            $adminModel = new AdminModel();
            $adminModel -> insert($data);
            //显示页面
            $this -> redirect('index.php?p=Admin&c=Admin&a=index');
        }
    }

    //员工信息的编辑
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//判定是页面展示还是数据修改
            //编辑页面展示
            //接收数据
            $id = $_GET['id'];
            //处理数据
            //调用模型查询该员工信息
            $adminModel = new AdminModel();
            $member = $adminModel -> EditGet($id);
            //分配数据到页面
            $this -> assign('member',$member);
            //调用模型查询所有部门信息
            $groupModel = new GroupModel();
            $group = $groupModel -> index();
            //分配数据到页面
            $this -> assign('group',$group);
            //显示页面
            $this -> display('edit');
        }else{
            //数据信息修改
            //接收数据
            $data = $_POST;
            $photo = $_FILES['photo'];
            //处理数据
            if($photo['error'] == 0){//判定是否有上传头像
                //调用模型处理文件上传
                $uploadModel = new UploadModel();
                $result = $uploadModel -> upload($photo,'member/');
                //判定是否成功
                if($result === false){
                    $this -> redirect("index.php?p=Admin&c=Admin&a=edit&id={$data['id']}",'上传图片时失败'.$this -> getError(),2);
                }else{
                    //调用模型制作缩略图
                    $imageModel = new ImageModel();
                    $photo_path = $imageModel -> thumb($result,100,100);
                    if($photo_path === false){
                        $this -> redirect("index.php?p=Admin&c=Admin&a=edit&id={$data['id']}",'制作头像时失败'.$this -> getError(),2);
                    }else{
                        $data['photo'] = $photo_path;
                    }
                }
            }
            if(empty($data['password'])){
                $this -> redirect("index.php?p=Admin&c=Admin&a=edit&id={$data['id']}",'你还没有输入登录密码',2);
            }
            //调用模型编辑员工信息
            $adminModel = new AdminModel();
            $adminModel -> edit($data);
            //显示页面
            $this -> redirect("index.php?p=Admin&c=Admin&a=index",'编辑员工信息成功',2);
        }
    }

    //员工信息的删除
    public function delete(){
        //接收数据
        $id = $_GET['id'];
        //处理数据
        $adminModel = new AdminModel();
        $result = $adminModel -> delete($id);
        if($result === false){
            $this -> redirect("index.php?p=Admin&c=Admin&a=index","删除员工信息失败!".$adminModel->getError(),2);
        }
        //显示页面
        $this -> redirect("index.php?p=Admin&c=Admin&a=index","删除员工信息成功",1);
    }

}