<?php

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    //初始化
    public function initialize()
    {
        if (session('?admin.id')){
            $this->redirect('admin/home/index');
        }
    }

    //后台登录
    public function login(){

        if (request()->isAjax()){
            //获取数据
            $data = [
              'username' => input('post.username'),
              'password' => input('post.password')
            ];
            //通过模型进行验证
            $result = model('Admin')->login($data);
            //判断模型的验证结果
            if ($result == 1){
                if(session('admin.is_super') == 1){
                    $this->success('尊敬的超级管理员，欢迎回来！！！','admin/home/index');
                }
                $this->success('普通管理员，欢迎回来！！！','admin/home/index');
            }else{
                $this->error($result);
            }
        }
        return view();
    }


    //后台注册
    public function register()
    {

        if (request()->isAjax()){
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email')
            ];
            //通过模型进行验证
            $result = model('Admin')->register($data);
            //判断模型的验证结果
            if ($result == 1){
                $this->success('注册成功！','admin/index/login');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

    //重置密码 发送验证码
    public function forget()
    {
        if (request()->isAjax()){
            $code = mt_rand(1000,9999);
            session('code',$code);
            $data = [
                'email' =>input('post.email')
            ];
            $result = mailto($data['email'],'重置密码','<h3>您的验证码为：'.$code.'</h3>');
            if ($result){
                $this->success('验证码发送成功！！！');
            }else{
                $this->error('验证码发送失败！！！');
            }
        }
        return view();
    }

    //重置密码 提交
    public function reset()
    {
        $data =[
            'code' => input('post.code'),
            'email' => input('post.email')
        ];
        $result = model('Admin') ->reset($data);
        if ($result == 1){
            $this->success('密码重置成功，请去邮箱查看新密码','admin/index/login');
        }else{
            $this->error($result);
        }
    }
}
