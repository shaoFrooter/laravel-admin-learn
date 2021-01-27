<?php
/**
 * Created by shaofeng
 * Date: 2021/1/5 13:01
 */

namespace App\Common\Util;


class RegexUtil
{
    public static function isEmail($string):bool
    {
        if (CommonUtil::isEmpty($string)) {
            return false;
        }
        $pattern = '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i';
        if (preg_match($pattern, $string)) {
            return true;
        }
        return false;
    }
}