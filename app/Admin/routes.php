<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

//    $router->get('/', 'HomeController@index')->name('home');
    //修改admin进入的首页
    $router->get('/', function (){
        return redirect('admin/voteCategory/manage');
    })->name('home');
    $router->get('/admin/dashboard',function (){
        return redirect('admin/voteCategory/manage');
    });
    $router->resource('user/manage',UserController::class);
    $router->resource('employees', EmployeeController::class);
    $router->resource('salary/manage', SalaryController::class);
    $router->resource('movie/manage', MovieController::class);
    $router->resource('painter/manage', PainterController::class);
    $router->resource('painting/manage', PaintingController::class);
    $router->resource('category/manage', CategoryController::class);
    $router->resource('voteRecord/manage', VoteRecordController::class);
    $router->resource('voteCandidate/manage', VoteCandidateController::class);
    $router->resource('voteUser/manage',VoteUserController::class);
    $router->resource('voteOption/manage',VoteOptionController::class);
    $router->resource('voteCategory/manage',VoteCategoryController::class);
});
