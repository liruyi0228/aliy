<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
route::any('/','IndexController@index');
//商品
route::prefix('goods')->group(function(){
   route::any('goodsList/{id?}','Goods\GoodsController@goodsList');
   route::any('goodscontent/{id}','Goods\GoodsController@goodscontent');
   route::any('goodscart','Goods\GoodsController@goodscart');
});

route::any('goods/goodsbb','Goods\GoodsController@goodsbb');
//个人中心
route::prefix('user')->group(function(){
   route::any('userpage','User\UserController@userpage');
   route::any('login','User\UserController@login');
    route::any('logindo','User\UserController@logindo');
   route::any('register','User\UserController@register');
   route::any('usertel','User\UserController@usertel');
   route::any('registerAdd','User\UserController@registerAdd');
});
route::any('verify/create','CaptchaController@create');

