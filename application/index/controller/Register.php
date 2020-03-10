<?php

namespace app\index\controller;

use think\Controller;

class Register extends Controller
{
    //用户注册
    public function register()
    {
        if (request()->isAjax()){
            $data = [
                'username'=>input('post.username'),
                'password'=>input('post.password'),
                'conpass'=>input('post.conpass'),
                'nickname'=>input('post.nickname'),
                'email'=>input('post.email'),
                'verify'=>input('post.verify')
            ];
            $result = model('Member')->register($data);
            if ($result == 1) {
                $this->success('注册成功', 'index/index/login');
            }else{
                $this->error($result);
            }
        }
        $cateInfo = model('Cate')->select();
        $webInfo = model('System')->find();
        $this->assign('webInfo',$webInfo);
        $this->assign('cateInfo',$cateInfo);
        return view();
    }
}
