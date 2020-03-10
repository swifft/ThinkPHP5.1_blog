<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{

    //前台首页
    public function index()
    {
        $articlesInfo = model('Article')->limit(10)->select();
        $articleInfo = model('Article')->order(['reading'=>'desc'])->paginate(5);
        $cateInfo = model('Cate')->select();
        $webInfo = model('System')->find();
        $catename = '博文列表';
        $this->assign('catename',$catename);
        $this->assign('webInfo',$webInfo);
        $this->assign('cateInfo',$cateInfo);
        $this->assign('articleInfo',$articleInfo);
        $this->assign('articlesInfo',$articlesInfo);
        return view();
    }

    //前台登录
    public function login()
    {
        if (request()->isAjax()){
            $data = [
                'username'=>input('post.username'),
                'password'=>input('post.password'),
                'verify'=>input('post.verify')
            ];
            $result = model('Member')->login($data);
            if ($result == 1) {
                $this->success('登录成功', 'index/index/index');
            }else{
                $this->error($result);
            }
        }
        $cateInfo = model('Cate')->select();
        $webInfo = model('System')->find();
        $this->assign('webInfo',$webInfo);
        $this->assign('cateInfo',$cateInfo);
        return view();
    }

    //前台退出
    public function exit()
    {
        session(null);
        if (session('?admin.id')){
            $this->error('退出失败！！！');
        }else{
            $this->success('退出成功！！！','index/index/index');
        }
    }

    //主页栏目
    public function cate()
    {
        $cate = model('Cate')->with('article')->order(['create_time' => 'desc'])->find(input('id'));
        $articleInfo = model('Article')->order(['reading'=>'desc'])->paginate(10);
        $cateInfo = model('Cate')->select();
        $webInfo = model('System')->find();
        $articlesInfo = model('Article')->limit(10)->select();
        $this->assign('webInfo',$webInfo);
        $this->assign('cateInfo',$cateInfo);
        $this->assign('articleInfo',$articleInfo);
        $this->assign('cate',$cate);
        $this->assign('articlesInfo',$articlesInfo);
        return view();
    }

    //搜索功能
    public function search(){
        $where[] = ['title', 'like', '%' . input('keyword') . '%'];
        $article = model('Article')->where($where)->order('create_time','desc')->paginate(5);
        $catename = input('keyword');
        $webInfo = model('System')->find();
        $cateInfo = model('Cate')->select();
        $articlesInfo = model('Article')->limit(10)->select();
        $this->assign('articlesInfo',$articlesInfo);
        $this->assign('cateInfo',$cateInfo);
        $this->assign('webInfo',$webInfo);
        $this->assign('articleInfo',$article);
        $this->assign('catename',$catename);
        return view('index');
    }
}
