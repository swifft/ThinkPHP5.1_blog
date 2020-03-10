<?php

namespace app\admin\controller;


class System extends Base
{
    //系统设置
    public function systemset()
    {
        if (request()->isAjax()){
            $data =[
                'id' => input('post.id'),
                'webname'=>input('post.webname'),
                'copyright'=>input('post.copyright')
            ];
            $result = model('System')->set($data);
            if ($result == 1){
                $this->success('修改成功！','admin/home/index');
            }else{
                $this->error($result);
            }
        }
        $webInfo = model('System')->find();
        $this->assign('webInfo',$webInfo);
        return view();
    }
}
