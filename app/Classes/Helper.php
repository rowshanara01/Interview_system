<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;

class Helper
{
    public static function sendResponse($result, $message, $code = 200, $requestName = 'result')
    {
        $response = [
            'success'    => true,
            'message'    => $message,
            $requestName => $result
        ];

        return response()->json($response, $code);
    }

    public static function sendError($message, $code = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    public static function checkPaginateSize($request)
    {
        $paginateSize        = $request->paginate_size;
        $maxPaginateSize     = config('crud.paginate_size.max');
        $defaultPaginateSize = config('crud.paginate_size.default');
        $paginateSize        = $paginateSize ?? $defaultPaginateSize;
        $paginateSize        = $paginateSize > $maxPaginateSize ? $maxPaginateSize : $paginateSize;

        return $paginateSize;
    }

    public static function timeFormat($time)
    {
        return $time ? Carbon::parse($time)->format('H:i:s') : null;
    }

    public static function dateFormat($date)
    {
        return $date ? Carbon::parse($date)->format('Y-m-d') : null;
    }
}
