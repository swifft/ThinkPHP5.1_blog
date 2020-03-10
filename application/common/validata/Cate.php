<?php


namespace app\common\validata;


use think\Validate;

class Cate extends Validate
{

    protected $rule = [
        'catename|栏目名称' => 'require|unique:cate',
        'catesort|排序' => 'require|number',
        'sort|排序' => 'require|number'
    ];

    public function sceneAdd()
    {
        return $this->only(['catename','catesort']);
    }

    public function sceneSort()
    {
        return $this->only(['sort']);
    }

    public function sceneEdit()
    {
        return $this->only(['catename']);
    }
}