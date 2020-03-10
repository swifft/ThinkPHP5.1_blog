<?php

namespace app\admin\controller;

class Member extends Base
{
    //会员列表
    public function memberlist()
    {
        $members = model('Member')->order('id','asc')->paginate(10);
        //定义一个模板数据变量
        $this->assign('members',$members);
        return view();
    }

    //会员添加
    public function memberadd()
    {
        if (request()->isAjax()){
            $data = [
                'username' =>input('post.username'),
                'password' =>input('post.password'),
                'nickname' =>input('post.nickname'),
                'email' =>input('post.email'),
            ];
            $result = model('Member')->add($data);
            if ($result == 1){
                $this->success('会员添加成功','admin/member/memberlist');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

    //会员编辑
    public function memberedit()
    {
        if (request()->isAjax()){
            $data = [
                'id'=>input('post.id'),
                'oldpass' =>input('post.oldpass'),
                'newpass' =>input('post.newpass'),
                'nickname' =>input('post.nickname'),
            ];
            $result = model('Member')->edit($data);
            if ($result == 1){
                $this->success('会员编辑成功！！！','admin/member/memberlist');
            }else{
                $this->error($result);
            }
        }
        $memberInfo = model('Member')->find(input('id'));
        $this->assign('memberInfo',$memberInfo);
        return view();
    }

    //会员删除
    public function memberdel()
    {
        $memberInfo = model('Member')->with('comments')->find(input('id'));
        $result = $memberInfo->together('comments')->delete();
        if ($result == 1){
            $this->success('会员信息删除成功','admin/member/memberlist');
        }else
        {
            $this->error($result);
        }
    }
}
