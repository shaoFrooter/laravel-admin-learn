<?php
/**
 * Created by shaofeng
 * Date: 2020/12/25 10:41
 */

namespace App\Service\impl;


use App\Models\AdminRoleUser;
use App\Models\AdminUser;
use App\Service\UserRegisterService;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRegisterServiceImpl implements UserRegisterService
{
    private $adminUser;
    private $adminRoleUser;

    public function __construct(AdminUser $adminUser, AdminRoleUser $adminRoleUser)
    {
        $this->adminUser = $adminUser;
        $this->adminRoleUser = $adminRoleUser;
    }

    public function register($name, $email, $password)
    {
        $result = DB::transaction(function () use ($name, $email, $password) {
            $hashPassword = Hash::make($password);
            //分别插入邮箱和用户名两个账号
            $administrator1 = ['username' => $name, 'password' => $hashPassword, 'name' => $name];
            $administrator2 = ['username' => $email, 'password' => $hashPassword, 'name' => $email];
            $builder = $this->adminUser->newQuery();
            $userId1 = $builder->insertGetId($administrator1);
            $userId2 = $builder->insertGetId($administrator2);
            //插入角色
            $this->adminRoleUser->newQuery()->insert([['role_id' => 3, 'user_id' => $userId1], ['role_id' => 3, 'user_id' => $userId2]]);
            //创建账号
            $result = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $hashPassword,
            ]);
            return $result;
        });
        return $result;

    }
}