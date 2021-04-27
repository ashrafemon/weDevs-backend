<?php

namespace app\Controllers;

use app\Core\Auth;
use app\Core\Request;
use app\Core\Response;
use app\Models\User;

class AuthController
{
    public static function login()
    {
        $request = Request::formRequest();
        if (!Auth::attemps($request['email'], $request['password'])) {
            return Response::apiResponse(['status' => 'error', 'message' => 'Credentials not matched']);
        }
        $token = Auth::createToken();
        return Response::apiResponse(['status' => 'done', 'token' => "Bearer $token"], 201);
    }

    public static function verify()
    {
        return Response::apiResponse(['status' => 'done', 'message' => Auth::verifyToken()], 200);
    }

    public static function register()
    {
        $request = Request::formRequest();
        if ((new User())->insert($request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Registration complete'], 201);
        }
    }

    public static function me()
    {
        Auth::verifyToken();
        return Response::apiResponse(['status' => 'done', 'user' => Auth::user()], 200);
    }
}