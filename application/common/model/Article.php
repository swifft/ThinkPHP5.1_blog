<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Article extends Model
{
    //软删除
    use SoftDelete;

    //关联栏目模型
    public function cate()
    {
        return $this->belongsTo('Cate','cate_id','id');
    }

    //关联评论
    public function comments()
    {
        return $this->hasMany('Comment','article_id','id')->order(['create_time'=>'desc']);
    }


    //文章添加
    public function add($data)
    {
        $validata = new  \app\common\validata\Article;
        if (!$validata->scene('add')->check($data)){
            return $validata->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result){
            return 1;
        }else{
            return '文章添加失败';
        }
    }

    //文章推荐
    public function top($data)
    {
        $validata = new  \app\common\validata\Article;
        if (!$validata->scene('top')->check($data)){
            return $validata->getError();
        }
        if ($data['is_top'] == 1){
            $data['is_top'] = 0;
        }else{
            $data['is_top'] = 1;
        }
        $articleInfo = $this->find($data['id']);
        $articleInfo->is_top = $data['is_top'];
        $result = $articleInfo->save();
        if ($result){
            return 1;
        }else{
            return '操作失败';
        }
    }

    //文章编辑
    public function edit($data)
    {
        $validata = new  \app\common\validata\Article;
        if (!$validata->scene('edit')->check($data)){
            return $validata->getError();
        }
        $articleInfo = $this->find($data['id']);
        $articleInfo->title = $data['title'];
        $articleInfo->desc = $data['desc'];
        $articleInfo->tags = $data['tags'];
        $articleInfo->content = $data['content'];
        $articleInfo->is_top = $data['is_top'];
        $articleInfo->cate_id = $data['cate_id'];
        $result = $articleInfo->save();
        if ($result){
            return 1;
        }else{
            return '文章编辑失败';
        }
    }
}
