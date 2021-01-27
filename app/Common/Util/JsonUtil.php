<?php
/**
 * Created by shaofeng
 * Date: 2020/12/11 15:14
 * Json操作工具类
 */

namespace App\Common\Util;


use App\Common\Exception\BusinessException;

class JsonUtil
{
    public static function toJson($object)
    {
        if (CommonUtil::isEmpty($object)) {
            throw new BusinessException("object is null");
        }
        return json_encode($object);
    }

    public static function toArray($jsonString)
    {
        if (CommonUtil::isEmpty($jsonString)) {
            throw new BusinessException("jsonString is null");
        }
        return json_decode($jsonString, true);
    }

    public static function decode($jsonString)
    {
        if (CommonUtil::isEmpty($jsonString)) {
            throw new BusinessException('jsonString is null');
        }
        return json_decode($jsonString);
    }
}