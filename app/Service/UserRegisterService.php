<?php
/**
 * Created by shaofeng
 * Date: 2020/12/25 10:39
 */

namespace App\Service;


interface UserRegisterService
{
    public function register($name,$email,$password);

}