<?php

namespace app\index\controller;

use think\Controller;

class articles extends Controller
{
    //文章页
    public function articles()
    {
        $articles = model('Article')->find(input('id'));
        $articles->setInc('reading');
        $articleComment = model('Article')->with('comments,comments.member')->find(input('id'));
        $articlesInfo = model('Article')->limit(10)->select();
        $webInfo = model('System')->find();
        $cateInfo = model('Cate')->select();
        $this->assign('cateInfo',$cateInfo);
        $this->assign('webInfo',$webInfo);
        $this->assign('articles',$articles);
        $this->assign('articlesInfo',$articlesInfo);
        $this->assign('articleComment',$articleComment);
        return view();
    }

    //用户评论
    public function com()
    {
        if (request()->isAjax()){
            $data = [
                'article_id' => input('post.article_id'),
                'member_id' => input('post.member_id'),
                'content' => input('post.comment')
            ];
            $result = model('Comment')->com($data);
            if ($result == 1){
                $res = model('Article')->find($data['article_id']);
                $res->setInc('comment_num');
                $this->success('评论成功');
            }else{
                $this->error($result);
            }
        }
    }
}
