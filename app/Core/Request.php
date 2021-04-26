<?php


namespace app\Core;


class Request
{
    public static function formRequest(): array
    {
        return (array)json_decode(file_get_contents('php://input'), TRUE);
    }
}