<?php
/**
 * Created by shaofeng
 * Date: 2020/12/11 15:15
 * 常用工具类
 */

namespace App\Common\Util;


class CommonUtil
{
    public static function isEmpty($string): bool
    {
        if ($string == null || empty($string)) {
            return true;
        }
        return false;
    }

    public static function isNull($object): bool
    {
        return $object == null;
    }

    public static function isNotNull($object): bool
    {
        return !self::isNull($object);
    }


    public static function isNotEmpty($string): bool
    {
        return !self::isEmpty($string);
    }
    public static function isEmail($string):bool
    {
        if (self::isEmpty($string)) {
            return false;
        }
        $pattern = '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i';
        if (preg_match($pattern, $string)) {
            return true;
        }
        return false;
    }
}