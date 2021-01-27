<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('password/reset1','MyAuthController@resetPasswordView');
Route::post('password/doRest','MyAuthController@doRest')->name('doRest');
//Route::post('vote/greeting','MyAuthController@greeting')->name('myAuthGreeting')->middleware('loginCheck');
Route::prefix('vote')->middleware('loginCheck')->group(function (){
    //注册
    Route::post('register','LoginController@register')->name('register');
    //登录
    Route::post('login','LoginController@login')->name('login');
    //投票列表
    Route::get('voteList','VoteController@voteList');
    //我创建的投票列表
    Route::get('myVoteList','VoteController@myVoteList');
    //投票
    Route::post('addVote','VoteController@addVote');
    //创建投票
    Route::post('createVote','VoteController@createVote');
    //更新投票
    Route::post('updateVote','VoteController@updateVote');
    //获取当前登录信息
    Route::get('userInfo','LoginController@getUserInfo');
    //投票详情
    Route::get('detail','VoteController@detail');
    //删除投票
    Route::post('deleteByVoteId','VoteController@deleteByVoteId');
    //退出登录
    Route::post('logout','LoginController@logout')->name('logout');
});
Route::get('detail','VoteController@detail');
//路由找不到统一处理
Route::fallback(function (){
    return response()->json(['code'=>500,'message'=>'失败']);
});
