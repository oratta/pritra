<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Exception;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const HTTP_STATUS_OK                = 200;
    const HTTP_STATUS_CREATE            = 201;
    const HTTP_STATUS_NO_CONTENT        = 204;
    const HTTP_STATUS_BAD_REQUEST       = 400;
    const HTTP_STATUS_UNAUTHORIZED      = 401;
    const HTTP_STATUS_NOT_IMPLEMENTED   = 501;

    protected function responseNotImplemented()
    {
        $where = $this->_calledFrom();
        Log::debug("not Implemented at $where");
        return response("test",self::HTTP_STATUS_NOT_IMPLEMENTED);
    }

    protected function responseBadRequest(Exception $e)
    {
        $where = $this->_calledFrom();
        Log::debug("bad request at $where");
        return abort($e->getCode(), $e->getMessage());
    }

    private function _calledFrom()
    {
        $trace = debug_backtrace();
        $file = $trace[1]['file'];
        $method = $trace[2]['function'];
        $line = $trace[1]['line'];
        return "$method@$file:$line";
    }

}
