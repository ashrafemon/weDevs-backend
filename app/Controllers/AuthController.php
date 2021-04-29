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
        if (!isset($request['email']) || !isset($request['password'])) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'email & password field is required'], 403);
        }
        if (!Auth::attemps($request['email'], $request['password'])) {
            return Response::apiResponse(['status' => 'error', 'message' => 'Credentials not matched']);
        }
        $token = Auth::createToken();
        return Response::apiResponse(['status' => 'done', 'message' => 'Login successful', 'token' => "Bearer $token", 'user' => Auth::user()], 201);
    }

    public static function verify()
    {
        if (Auth::verifyToken()) {
            return Response::apiResponse(['status' => 'done', 'message' => 'authenticated'], 200);
        } else {
            return Response::apiResponse(['status' => 'error', 'message' => 'unauthenticated'], 401);
        }
    }

    public static function register()
    {
        $request = Request::formRequest();
        if (!isset($request['name']) || !isset($request['email']) || !isset($request['password'])) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'name , email & password field is required'], 403);
        }
        $exist = (new User())->findByEmail($request['email']);
        if ($exist) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'email already taken'], 403);
        }
        if ((new User())->insert($request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Registration complete'], 201);
        }
    }

    public static function me()
    {
        if (Auth::verifyToken()) {
            return Response::apiResponse(['status' => 'done', 'user' => Auth::user()], 200);
        } else {
            return Response::apiResponse(['status' => 'error', 'message' => 'unauthenticated'], 401);
        }
    }
}