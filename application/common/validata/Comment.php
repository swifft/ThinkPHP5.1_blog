<?php


namespace app\common\validata;


use think\Validate;

class Comment extends Validate
{

    protected $rule =[
        'content|内容' => 'require'
    ];


    public function sceneCom()
    {
        return $this->only(['content']);
    }
}