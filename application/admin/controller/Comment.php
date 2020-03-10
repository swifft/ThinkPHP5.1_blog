<?php

namespace app\admin\controller;

use think\Controller;

class Comment extends Base
{
    //评论管理
    public function comment()
    {
        $commentInfo = model('Comment')->with('article,member')->order(['create_time'=>'desc'])->paginate(10);
        $this->assign('commentInfo',$commentInfo);
        return view();
    }

    //评论删除
    public function commentdel()
    {
        $commentInfo = model('Comment')->find(input('id'));
        $result = $commentInfo->delete();
        if ($result == 1){
            $this->success('删除成功！','admin/comment/comment');
        }else{
            $this->error($result);
        }
    }
}
