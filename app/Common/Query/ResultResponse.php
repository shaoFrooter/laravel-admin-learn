<?php
/**
 * Created by shaofeng
 * Date: 2020/12/31 16:56
 */

namespace App\Common\Query;


class ResultResponse
{
    public $code=200;

    public $message;

    public $data;

    private static function buildResult($code,$message,$data){
        $response=new ResultResponse();
        $response->setCode($code);
        $response->setMessage($message);
        $response->setData($data);
        return $response;
//        return JsonUtil::toJson($response);
    }

    public static function success($message,$data){
        return self::buildResult(200,$message,$data);
    }

    public static function fail($code,$message,$data){
        return self::buildResult($code,$message,$data);
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}