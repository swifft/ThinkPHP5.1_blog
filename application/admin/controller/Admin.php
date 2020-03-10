<?php

namespace app\admin\controller;

use think\Controller;

class Admin extends Base
{
    //管理员列表
    public function adminlist()
    {
        $admins = model('Admin')->order(['is_super'=>'desc','status'=>'desc'])->paginate(10);
        $this->assign('admins',$admins);
        return view();
    }

    //管理员添加
    public function adminadd()
    {
        if (request()->isAjax()){
            $data =[
                'username'=>input('post.username'),
                'password'=>input('post.password'),
                'nickname'=>input('post.nickname'),
                'email'=>input('post.email')
            ];
            $result = model('Admin')->add($data);
            if ($result == 1){
                $this->success('管理员添加成功','admin/admin/adminlist');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

    //管理员状态
    public function adminstatus()
    {
        if (request()->isAjax()){
            $data =[
                'id'=>input('post.id'),
                'status'=>input('post.status')
            ];
            $result = model('Admin')->status($data);
            if ($result == 1){
                $this->success('管理员状态变更成功','admin/admin/adminlist');
            }else{
                $this->error($result);
            }
        }
    }

    //管理员删除
    public function admindel()
    {
        $adminInfo = model('Admin')->find(input('id'));
        $result = $adminInfo->delete();
        if ($result ==1){
            $this->success('管理员信息删除成功！','admin/admin/adminlist');
        }else{
            $this->error($result);
        }
    }

    //管理员编辑
    public function adminedit()
    {
        if (request()->isAjax()){
            $data =[
                'id'=>input('post.id'),
                'oldpass'=>input('post.oldpass'),
                'newpass'=>input('post.newpass'),
                'nickname'=>input('post.nickname')
            ];
            $result = model('Admin')->edit($data);
            if ($result == 1){
                $this->success('管理员信息编辑成功','admin/admin/adminlist');
            }else{
                $this->error($result);
            }
        }
        $adminInfo = model('Admin')->find(input('id'));
        $this->assign('adminInfo',$adminInfo);
        return view();
    }
}
