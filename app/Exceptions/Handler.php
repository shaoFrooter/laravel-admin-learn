<?php

namespace App\Exceptions;

use App\Common\Exception\VoteException;
use App\Common\Query\ResultResponse;
use App\Common\Util\JsonUtil;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof VoteException) {
            Log::warning('------VoteException------' . $exception->getTraceAsString());
            return response(JsonUtil::toJson(ResultResponse::fail(500, $exception->getMessage(), '')));
        }
        Log::warning('------Exception------' . $exception->getTraceAsString());
        return response(JsonUtil::toJson(ResultResponse::fail(500, '服务出问题啦', '')));
    }
}
