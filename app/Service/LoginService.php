<?php
/**
 * Created by shaofeng
 * Date: 2021/1/5 9:17
 */

namespace App\Service;


use App\Common\Query\ResultResponse;

interface LoginService
{
    public function register(string $username,string $email,string $password):ResultResponse;

    public function login(string $username,string $password):ResultResponse;

    public function userInfo($userId);

    public function logout();

}