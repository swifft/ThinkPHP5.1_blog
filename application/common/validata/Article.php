<?php


namespace app\common\validata;


use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title|文章标题' =>'require|unique:Article',
        'author|文章作者' =>'require',
        'desc|文章概要' =>'require',
        'tags|文章标签' =>'require',
        'content|文章内容' =>'require',
        'is_top|文章是否推荐' =>'require',
        'cate_id|所属栏目' =>'require'
    ];


    //添加场景
    public function sceneAdd()
    {
        return $this->only(['title','author','desc','tags','is_top','cate_id','content']);
    }

    public function sceneTop()
    {
        return $this->only(['is_top']);
    }

    public function sceneEdit()
    {
        return $this->only(['title','desc','tags','is_top','cate_id','content']);
    }
}