<?php

namespace app\admin\controller;


class Cate extends Base
{
    //栏目列表
    public function catelist()
    {
        $cates = model('Cate')->order('catesort','asc')->paginate(10);
        //定义一个模板数据变量
        $viewData = [
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }

    //栏目添加
    public function cateadd()
    {
        if (request()->isAjax()){
            $data = [
                'catename' =>input('post.catename'),
                'catesort' =>input('post.catesort')
            ];
            $result = model('Cate')->add($data);
            if ($result == 1){
                $this->success('栏目添加成功','admin/cate/catelist');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

    //栏目排序
    public function sort()
    {
        $data = [
            'id' => input('post.id'),
            'sort' => input('post.sort')
        ];
        $result = model('Cate')->sort($data);
        if ($result == 1){
            $this->success('排序成功！！！','admin/cate/catelist');
        }else{
            $this->error($result);
        }
    }

    //栏目编辑
    public function cateedit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'catename' => input('post.catename')
            ];
            $result = model('Cate')->edit($data);
            if ($result == 1){
                $this->success('栏目添加成功','admin/cate/catelist');
            }else{
                $this->error($result);
            }
        }
        $cateInfo = model('Cate')->find(input('id'));
        $this->assign('cateInfo',$cateInfo);
        return view();
    }

    //栏目删除
    public function catedel()
    {
        $cateInfo = model('Cate')->with('article,article.comments')->find(input('id'));
        foreach ($cateInfo['article'] as $k => $v){
            $v->together('comments')->delete();
        }
        $result = $cateInfo->together('article')->delete();
        if ($result == 1){
            $this->success('栏目删除成功','admin/cate/catelist');
        }else{
            $this->error($result);
        }
    }
}
