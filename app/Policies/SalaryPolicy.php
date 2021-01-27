<?php
/**
 * Created by shaofeng
 * Date: 2020/12/28 13:27
 */

namespace App\Policies;


use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Support\Facades\Auth;

class SalaryPolicy
{
    public function hasCreate(Administrator $administrator){
        $userId=Auth::id();
        if($userId==1){
            return false;
        }
    }

}