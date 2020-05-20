<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const HTTP_STATUS_CREATE = 201;
    const HTTP_STATUS_OK = 200;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_UNAUTHORIZED = 401;

    protected function returnNotImplemented()
    {
        return response("test",self::HTTP_NOT_IMPLEMENTED);
    }

}
