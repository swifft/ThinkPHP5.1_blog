<?php

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    //初始化方法
    public function initialize()
    {
        if (!session('?admin.id')){
            $this->redirect('admin/index/login');
        }
    }
}
