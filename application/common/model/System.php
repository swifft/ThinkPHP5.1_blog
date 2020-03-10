<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class System extends Model
{
    //软删除
    use SoftDelete;

    //系统设置
    public function set($data)
    {
        $validata = new \app\common\validata\System;
        if (!$validata->check($data)){
            return $validata->getError();
        }
        $webInfo = $this->find($data['id']);
        $webInfo->webname = $data['webname'];
        $webInfo->copyright = $data['copyright'];
        $result = $webInfo->save();
        if ($result){
            return 1;
        }else{
            return '修改失败！';
        }
    }

}
