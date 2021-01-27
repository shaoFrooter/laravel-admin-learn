<?php
/**
 * Created by shaofeng
 * Date: 2021/1/5 9:14
 */

namespace App\Http\Controllers;


use App\Common\Exception\VoteException;
use App\Common\Query\ResultResponse;
use App\Common\Util\CommonUtil;
use App\Common\Util\JsonUtil;
use App\Common\Util\RegexUtil;
use App\Common\Util\UserUtil;
use App\Service\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    private $loginService;


    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function register(Request $request)
    {
        $email = $request->get('email');
        $userName = $request->get('username');
        $password = $request->get('passwd');
        $passwordCheck = $request->get('passwdCheck');
        $this->registerCheck($email, $userName, $password, $passwordCheck);
        return JsonUtil::toJson($this->loginService->register($userName, $email, $password));
    }

    public function login(Request $request)
    {
        $userName = $request->get('username');
        $password = $request->get('passwd');
        return JsonUtil::toJson($this->loginService->login($userName, $password));
    }

    public function logout(){
        return JsonUtil::toJson($this->loginService->logout());
    }

    public function getUserInfo()
    {
        $userId = UserUtil::getUserId();
        $userInfo = $this->loginService->userInfo($userId);
        return JsonUtil::toJson(ResultResponse::success(null, $userInfo));
    }

    public function registerCheck($email, $username, $password, $passwordCheck)
    {
        $this->emailCheck($email);
        $this->userNameCheck($username);
        $this->passwordCheck($password, $passwordCheck);
    }

    public function emailCheck($email)
    {
        if (!RegexUtil::isEmail($email)) {
            throw new VoteException('邮箱地址格式不正确');
        }
    }

    public function userNameCheck($username)
    {
        if (CommonUtil::isEmpty($username)) {
            throw new VoteException('用户名不可为空');
        }
        $userNameLen = strlen($username);
        if ($userNameLen < 8 || $userNameLen > 20) {
            throw new VoteException('用户名的长度在8到20个字符之间');
        }
    }

    public function passwordCheck($password, $pwdCheck)
    {
        if (CommonUtil::isEmpty($password) || CommonUtil::isEmpty($pwdCheck)) {
            throw new VoteException('密码不可为空');
        }
        if ($password != $pwdCheck) {
            throw new VoteException('密码不一致');
        }
    }
}