<?php
/**
 * Created by shaofeng
 * Date: 2021/1/8 17:37
 */

namespace App\Common\Util;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class DateUtil
{
    /**
     * @var string
     * @link https://www.php.net/manual/en/datetime.format.php
     */
    private static $y1='Y-m-d H:i:s';

    private static $y2='Y/m/d H:i:s';

    public static final function today()
    {
        return self::formatDate(Date::now(),self::$y1);
    }

    public static final function formatDateDefault(Carbon $carbon){
        return self::formatDate($carbon,self::$y1);
    }

    public static final function formatDate(Carbon $carbon,$stringFormat){
        return $carbon->format($stringFormat);
    }

    public static final function number2Date($millis){
        return Date::createFromTimestampMs($millis);
    }

    public static final function string2Date($stringDate){
        return Date::createFromTimeString($stringDate);
    }
}