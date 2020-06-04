<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

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
        $trace = debug_backtrace();
        $class = get_called_class();
        $method = $trace[1]['function'];
        $where = "$method@$class";
        Log::debug("not Implemented at $where");
        return response("test",self::HTTP_STATUS_NOT_IMPLEMENTED);
    }

}
