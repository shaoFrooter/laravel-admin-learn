<?php
/**
 * Created by shaofeng
 * Date: 2021/1/5 9:19
 */

namespace App\Service\impl;


use App\Common\Constant\CommonCode;
use App\Common\Entity\VoteUserEntity;
use App\Common\Exception\VoteException;
use App\Common\Info\UserInfo;
use App\Common\Query\ResultResponse;
use App\Common\Util\CommonUtil;
use App\Common\Util\EncryptUtil;
use App\Common\Util\RegexUtil;
use App\Common\Util\UserUtil;
use App\Models\VoteUser;
use App\Service\LoginService;

class LoginServiceImpl implements LoginService
{
    private $voteUser;

    /**
     * LoginServiceImpl constructor.
     * @param $voteUser
     */
    public function __construct(VoteUser $voteUser)
    {
        $this->voteUser = $voteUser;
    }


    public function register(string $username, string $email, string $password):ResultResponse
    {
        $existCheck =$this->voteUser->selectByNickNameOrEmail($username, $email,null);
        if ($existCheck != null) {
            return ResultResponse::fail(CommonCode::ERROR, '当前用户名或邮箱账号已经存在', '');
        }
        $voteUserEntity = new VoteUserEntity();
        $voteUserEntity->setEmail($email);
        $voteUserEntity->setNickName($username);
        $voteUserEntity->setPassword(EncryptUtil::encryptString($password));
        $voteUserEntity->setAvatar('');
//        $dateNow=now();
        $this->voteUser->insertModel($voteUserEntity);
        return ResultResponse::success('ok', '');
    }

    public function login(string $username, string $password):ResultResponse
    {
        if (RegexUtil::isEmail($username)) {
            $result = $this->voteUser->selectByNickNameOrEmail(null, $username,EncryptUtil::encryptString($password));
            if ($result == null) {
                return ResultResponse::fail(CommonCode::ERROR, '用户名或密码错误', '');
            }
            return ResultResponse::success('登录成功', $result[0]['id']);
        }
        $result = $this->voteUser->selectByNickNameOrEmail($username, null,EncryptUtil::encryptString($password));
        if ($result == null) {
            return ResultResponse::fail(CommonCode::ERROR, '用户名或密码错误', '');
        }
        return ResultResponse::success('登录成功', $result[0]['id']);

    }

    public function userInfo($userId)
    {
        if (CommonUtil::isEmpty($userId)) {
            throw new VoteException('缺少userId');
        }
        $user = $this->voteUser->selectByIdWithEntity($userId);
        if ($user == null) {
            return null;
        }
        $userInfo = new UserInfo();
        $userInfo->setId($user->getId());
        $userInfo->setNickName($user->getNickName());
        $userInfo->setEmail($user->getEmail());
        return $userInfo;
    }

    public function logout()
    {
        UserUtil::dropUser();
        return ResultResponse::success('退出成功',null);
    }


}