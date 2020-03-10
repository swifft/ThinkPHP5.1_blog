<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Cate extends Model
{
    //软删除
    use SoftDelete;

    //关联文章
    public function article(){
        return $this->hasMany('Article','cate_id','id');
    }


    //栏目添加
    public function add($data)
    {
        $validata = new \app\common\validata\Cate;
        if (!$validata->scene('add')->check($data)){
            return $validata->getError();
        }else{
            $result = $this->allowField(true)->save($data);
            if ($result){
                return 1;
            }else{
                return '栏目添加失败';
            }
        }
    }

    //栏目排序
    public function sort($data)
    {
        $validata = new \app\common\validata\Cate;
        if (!$validata->scene('sort')->check($data)){
            return $validata->getError();
        }
        $cateInfo = $this->find($data['id']);
        $cateInfo->catesort = $data['sort'];
        $result = $cateInfo->save();
        if ($result){
            return 1;
        }else {
            return '排序失败';
        }

    }

    //栏目编辑
    public function edit($data)
    {
        $validata = new \app\common\validata\Cate;
        if (!$validata->scene('edit')->check($data)){
            return $validata->getError();
        }
        $cateInfo = $this->find($data['id']);
        $cateInfo->catename = $data['catename'];
        $result = $cateInfo->save();
        if ($result){
            return 1;
        }else {
            return '栏目编辑失败';
        }
    }
}
