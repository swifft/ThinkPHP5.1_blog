<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Member extends Model
{
    //软删除
    use SoftDelete;

    //只读字段
    protected $readonly=['username','email'];

    //管理评论
    public function comments()
    {
        return $this->hasMany('Comment','member_id','id');
    }


    //会员添加
    public function add($data)
    {
        $validata = new \app\common\validata\Member;
        if (!$validata->scene('add')->check($data)){
            return $validata->getError();
        }else{
            $result = $this->allowField(true)->save($data);
            if ($result){
                return 1;
            }else{
                return '会员添加失败';
            }
        }
    }

    //会员编辑
    public function edit($data)
    {
        $validata = new \app\common\validata\Member;
        if (!$validata->scene('edit')->check($data)){
            return $validata->getError();
        }else{
            $memberInfo = $this->find($data['id']);
            if ($memberInfo['password'] != $data['oldpass']){
                return '原密码不正确';
            }
            $memberInfo->password =$data['newpass'];
            $memberInfo->nickname = $data['nickname'];
            $result = $memberInfo->save();
            if ($result){
                return 1;
            }else{
                return '会员添加失败';
            }
        }
    }


    //前台注册
    public function register($data)
    {
        $validata = new \app\common\validata\Member;
        if (!$validata->scene('register')->check($data)){
            return $validata->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result){
            return 1;
        }else{
            return '会员注册失败';
        }

    }

    //前台登录
    public function login($data)
    {
        $validata = new \app\common\validata\Member;
        if (!$validata->scene('login')->check($data)){
            return $validata->getError();
        }
        unset($data['verify']);
        $memberInfo = $this->where($data)->find();
        if ($memberInfo){
            $sessionData = [
                'id' => $memberInfo['id'],
                'nickname' => $memberInfo['nickname'],
                'email' =>$memberInfo['email']
            ];
            session('index',$sessionData);
            return 1;
        }else{
            return '会员登录失败';
        }
    }
}
