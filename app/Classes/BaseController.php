<?php

namespace App\Classes;

use App\Classes\Helper;
use Illuminate\Routing\Controller;
class BaseController extends Controller
{
    function sendResponse($result, $message, $code = 200, $requestName = 'result')
    {
        return Helper::sendResponse($result, $message, $code, $requestName);
    }

    function sendError($message, $code = 500 )
    {
        return Helper::sendError($message, $code);
    }

    public function checkPaginateSize($paginate = null)
    {
        $maxPaginate     = config('crud.paginate.max');
        $defaultPaginate = config('crud.paginate.default');
        $paginate        = $paginate ?? $defaultPaginate;
        $paginate        = $paginate > $maxPaginate ? $maxPaginate : $paginate;

        return $paginate;
    }

}
