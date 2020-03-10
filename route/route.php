<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//前台路由
Route::rule('index', 'index/index/index', 'get|post');
Route::rule('article-<id>', 'index/articles/articles', 'get|post');
Route::rule('register', 'index/register/register', 'get|post');
Route::rule('login', 'index/index/login', 'get|post');
Route::rule('exit', 'index/index/exit', 'post');
Route::rule('com', 'index/article/com', 'post');
Route::rule('cate/[:id]', 'index/index/cate', 'get|post');
Route::rule('search', 'index/index/search', 'get');

//后台路由
Route::group('admin',function () {
    Route::rule('/', 'admin/index/login', 'get|post');
    Route::rule('register','admin/index/register','get|post');
    Route::rule('forget','admin/index/forget','get|post');
    Route::rule('reset','admin/index/reset','post');
    Route::rule('index','admin/home/index','get');
    Route::rule('loginout','admin/home/loginout','post');
    Route::rule('catelist','admin/cate/catelist','get');
    Route::rule('cateadd','admin/cate/cateadd','get|post');
    Route::rule('catesort','admin/cate/sort','post');
    Route::rule('cateedit/[:id]','admin/cate/cateedit','get|post');
    Route::rule('catedel','admin/cate/catedel','post');
    Route::rule('articlelist','admin/article/articlelist','get');
    Route::rule('articleadd','admin/article/articleadd','get|post');
    Route::rule('articletop','admin/article/articletop','post');
    Route::rule('articleedit/[:id]','admin/article/articleedit','get|post');
    Route::rule('articledel','admin/article/articledel','post');
    Route::rule('memberlist','admin/member/memberlist','get');
    Route::rule('memberadd','admin/member/memberadd','get|post');
    Route::rule('memberedit/[:id]','admin/member/memberedit','get|post');
    Route::rule('memberdel','admin/member/memberdel','post');
    Route::rule('comment','admin/comment/comment','get|post');
    Route::rule('commentdel','admin/comment/commentdel','post');
    Route::rule('adminlist','admin/admin/adminlist','get');
    Route::rule('adminadd','admin/admin/adminadd','get|post');
    Route::rule('adminstatus','admin/admin/adminstatus','post');
    Route::rule('admindel','admin/admin/admindel','post');
    Route::rule('adminedit/[:id]','admin/admin/adminedit','get|post');
    Route::rule('systemset','admin/system/systemset','get|post');
});
