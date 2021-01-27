<?php
/**
 * Created by shaofeng
 * Date: 2021/1/11 11:13
 */

namespace App\Common\Util;


use App\Common\Constant\CommonConst;

class UserUtil
{
    public static final function hasUserId(): bool
    {
        return session()->has(CommonConst::USERID);
    }

    public static final function putUserId($userId)
    {
        session()->put(CommonConst::USERID, $userId);
        return true;
    }

    public static final function putIfNotExist($userId)
    {
        if (self::hasUserId()) {
            return false;
        }
        return self::putUserId($userId);
    }

    public static final function getUserId()
    {
        return session()->get(CommonConst::USERID);
    }

    public static final function dropUser(){
        if (self::hasUserId()){
            session()->forget(CommonConst::USERID);
        }
    }
}