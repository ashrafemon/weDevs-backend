<?php

namespace app\Core;

class Response
{
    public static function apiResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        return json_encode($data);
    }
}