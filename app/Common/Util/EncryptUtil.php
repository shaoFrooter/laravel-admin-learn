<?php
/**
 * Created by shaofeng
 * Date: 2021/1/4 15:55
 */

namespace App\Common\Util;


class EncryptUtil
{
    private static $key='aBcDeFgHiJklmn';
    public static function encryptString(string $str){
        if(CommonUtil::isEmpty($str)){
            return '';
        }
        return base64_encode($str.'-'.self::$key);
    }

    public static function decodeString(string $str){
        if(CommonUtil::isEmpty($str)){
            return '';
        }
        $decodeResult= base64_decode($str);
        return substr($decodeResult,0,strpos($decodeResult,'-'));
    }

}