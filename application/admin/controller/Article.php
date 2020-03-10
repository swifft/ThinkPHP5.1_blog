<?php

namespace app\admin\controller;

class Article extends Base
{
    //文章列表
    public function articlelist()
    {
        $articles = model('Article')->with('cate')->order(['is_top'=>'desc'])->paginate(10);
        $this->assign('articles',$articles);
        return view();
    }


    //文章添加
    public function articleadd()
    {
        if (request()->isAjax()){
            $data =[
                'title'=>input('post.title'),
                'author'=>input('post.author'),
                'desc'=>input('post.desc'),
                'tags'=>input('post.tags'),
                'is_top'=>input('post.is_top',0),
                'cate_id'=>input('post.cate_id'),
                'content'=>input('post.content')
            ];
            $result = model('Article')->add($data);
            if ($result == 1){
                $this->success('添加成功','admin/article/articlelist');
            }else{
                $this->error($result);
            }
        }
        $cates = model('Cate')->select();
        $this->assign('cates',$cates);
        return view();
    }

    //文章推荐
    public function articletop()
    {
        $data = [
            'id'=>input('post.id'),
            'is_top'=>input('post.is_top')
        ];
        $result = model('Article')->top($data);
        if ($result == 1){
            $this->success('操作成功！！！','admin/article/articlelist');
        }else{
            $this->error($result);
        }
    }

    //文章编辑
    public function articleedit()
    {
        if (request()->isAjax()){
            $data =[
                'id'=>input('post.id'),
                'title'=>input('post.title'),
                'desc'=>input('post.desc'),
                'tags'=>input('post.tags'),
                'is_top'=>input('post.is_top',0),
                'cate_id'=>input('post.cate_id'),
                'content'=>input('post.content')
            ];
            $result = model('Article')->edit($data);
            if ($result == 1){
                $this->success('文章修改成功','admin/article/articlelist');
            }else{
                $this->error($result);
            }
        }
        $articleInfo = model('Article')->find(input('id'));
        $cates = model('Cate')->select();
        $this->assign('articleInfo',$articleInfo);
        $this->assign('cates',$cates);
        return view();
    }

    //文章删除
    public function articledel()
    {
        $articleInfo = model('Article')->with('comments')->find(input('post.id'));
        $result = $articleInfo->together('comments')->delete();
        if ($result == 1){
            $this->success('文章删除成功','admin/article/articlelist');
        }else{
            $this->error($result);
        }
    }
}
