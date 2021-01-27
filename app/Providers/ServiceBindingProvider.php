<?php
/**
 * Created by shaofeng
 * Date: 2020/12/25 10:44
 */

namespace App\Providers;


use App\Service\impl\LoginServiceImpl;
use App\Service\impl\UserRegisterServiceImpl;
use App\Service\impl\VoteServiceImpl;
use App\Service\LoginService;
use App\Service\UserRegisterService;
use App\Service\VoteService;
use Illuminate\Support\ServiceProvider;

class ServiceBindingProvider extends ServiceProvider
{
    public $bindings = [
        UserRegisterService::class => UserRegisterServiceImpl::class,
        VoteService::class => VoteServiceImpl::class,
        LoginService::class => LoginServiceImpl::class
    ];
}