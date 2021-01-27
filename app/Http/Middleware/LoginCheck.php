<?php
/**
 * Created by shaofeng
 * Date: 2021/1/4 16:38
 * 登录校验
 */

namespace App\Http\Middleware;


use App\Common\Constant\CommonCode;
use App\Common\Query\ResultResponse;
use App\Common\Util\EncryptUtil;
use App\Common\Util\JsonUtil;
use App\Common\Util\UserUtil;
use App\Service\LoginService;
use Illuminate\Http\Request;

class LoginCheck
{

    private $loginService;

    private $loginCookieName = 'loginCookieName';

    /**
     * LoginCheck constructor.
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function handle(Request $request, \Closure $next)
    {
        $routeName = $request->route()->getName();
        //如果是登录
        if ($routeName == 'login') {
            $userName = $request->get('username');
            $password = $request->get('passwd');
            $responseResult = $this->loginService->login($userName, $password);
            //登录成功
            if ($responseResult->getCode() == 200) {
                UserUtil::putUserId($responseResult->getData());
                $loginCookieValue = $request->cookie($this->loginCookieName);
                //登录成功之后cookie中没有值则将值设置进去
                if ($loginCookieValue == null) {
                    $loginCookieValue = $userName . '-' . EncryptUtil::encryptString($password).'-'.EncryptUtil::encryptString($responseResult->getData());
                    return $next($request)->withCookie(\cookie($this->loginCookieName, $loginCookieValue, 24*60));
                } else {
                    //如果有值则拿出来校验
                    $valueArray = explode('-', $loginCookieValue);
                    if ($valueArray[0] == $userName && $valueArray[1] == EncryptUtil::encryptString($password)) {
                        return $next($request);
                    }
                    //cookie中的值与表单不一致，则更新cookie
                    $loginCookieValue = $userName . '-' . EncryptUtil::encryptString($password).'-'.EncryptUtil::encryptString($responseResult->getData());
                    return $next($request)->withCookie(\cookie($this->loginCookieName, $loginCookieValue, 24*60));
                }
            } else {
                //登录失败
                return response(JsonUtil::toJson(ResultResponse::fail(CommonCode::LOGIN, $responseResult->getMessage(), '')));
            }
        } elseif ($routeName == 'register') {
            return $next($request);
        }elseif($routeName=='logout'){
            if($request->hasCookie($this->loginCookieName)){
                //删除cookie
                return $next($request)->withCookie(cookie($this->loginCookieName, '-', 0));
            }
        }
        //其他访问
        $loginCookieValue = $request->cookie($this->loginCookieName);
        if ($loginCookieValue == null) {
            return response(JsonUtil::toJson(ResultResponse::fail(CommonCode::LOGIN, '登录失败', '')));
        }
        $valueArray = explode('-', $loginCookieValue);
        $pwd = EncryptUtil::decodeString($valueArray[1]);
        $loginResponse = $this->loginService->login($valueArray[0], $pwd);
        if ($loginResponse->getCode() == 200) {
            UserUtil::putUserId($loginResponse->getData());
            return $next($request);
        }
        return response(JsonUtil::toJson(ResultResponse::fail(CommonCode::LOGIN, '登录失败', '')));
    }
}