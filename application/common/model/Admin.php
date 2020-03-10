<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    //软删除
    use SoftDelete;

    //登录校验
    public function login($data)
    {
        //实例化验证器
        $validata = new \app\common\validata\Admin;
        //验证器验证，验证不通过
        if(!$validata->scene('login')->check($data)){
            return $validata->getError();
        }
        //验证通过，数据库查找
        $result = $this->where($data)->find();
        //查找判断
        if ($result){
            //判断权限
            if ($result['status'] != 1){
                return '此账户被禁用';
            }
            $sessionData = [
                'id' => $result['id'],
                'nickname' => $result['nickname'],
                'is_super' => $result['is_super'],
                'email' =>$result['email']
            ];
            session('admin',$sessionData);
            //成功返回1
            return 1;
        }else{
            return '用户名或者密码错误!';
        }
    }

    //注册校验
    public function register($data)
    {
        $validata = new \app\common\validata\Admin;
        if (!$validata->scene('register')->check($data)){
            return $validata->getError();
        }
        $result = $this->allowField(true)->save($data);
        $body = '<h1>您好：'.$data['nickname'].'</h1><br>&nbsp;&nbsp;<h2>恭喜你成为Mr.Deng后台管理系统的普通用户！！</h2>' . date('Y-m-d H:i:s');
        if ($result){
            mailto($data['email'],'注册管理员账户成功！',$body);
            //数据库写入成功
            return 1;
        }else{
            return '注册失败';
        }
    }

    //重置密码
    public function reset($data)
    {
        $validata = new \app\common\validata\Admin;
        if (!$validata->scene('reset')->check($data)){
            return $validata->getError();
        }
        if ($data['code'] != session('code')){
            return '验证码不正确';
        }
        $adminInfo = $this->where('email',$data['email'])->find();
        $password = mt_rand(10000,99999);
        $adminInfo->password = $password;
        $result = $adminInfo->save();
        if ($result){
            $content = '恭喜您，密码重置成功！<br>用户名'.$adminInfo['username'].'<br>新密码：'.$password;
            mailto($data['email'],'密码重置成功',$content);
            return 1;
        }else{
            return '密码重置失败！！！';
        }
    }

    //管理员添加
    public function add($data)
    {
        $validata = new \app\common\validata\Admin;
        if (!$validata->scene('add')->check($data)){
            return $validata->getError();
        }
        if (session('admin.is_super') == 1){
            $result = $this->allowField(true)->save($data);
            if ($result){
                return 1;
            }else{
                return '添加失败';
            }
        }else{
            return '您不是超级管理员，不具有添加管理员权限！';
        }
    }

    //管理员状态变更
    public function status($data)
    {
        $validata = new \app\common\validata\Admin;
        if (!$validata->scene('status')->check($data)){
            return $validata->getError();
        }
        if ($data['status'] ==1){
            $data['status'] = 0;
        }else{
            $data['status'] = 1;
        }
        $adminInfo = $this->find($data['id']);
        $adminInfo->status = $data['status'];
        $result = $adminInfo->save();
        if ($result){
            return 1;
        }else{
            return '状态变更失败！';
        }
    }

    //管理员编辑
    public function edit($data)
    {
        $validata = new \app\common\validata\Admin;
        if (!$validata->scene('edit')->check($data)){
            return $validata->getError();
        }
        $adminInfo = $this->find($data['id']);
        if ($data['oldpass'] != $adminInfo['password']){
            return '原密码不正确';
        }
        $adminInfo->password = $data['newpass'];
        $adminInfo->nickname = $data['nickname'];
        $result = $adminInfo->save();
        if ($result){
            return 1;
        }else{
            return '管理员编辑失败！';
        }
    }
}
