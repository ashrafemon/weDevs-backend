<?php

namespace app\Controllers;

use app\Core\Auth;
use app\Core\Request;
use app\Core\Response;
use app\Models\Order;

class OrderController
{
    public static function store()
    {
        $verifyToken = Auth::verifyToken();
        if (count(Auth::user())) {
            $request = Request::formRequest();
            if ((new Order())->insert($request, Auth::user())) {
                return Response::apiResponse(['status' => 'done', 'message' => 'Order created successfully'], 201);
            }
        } else {
            return Response::apiResponse(['status' => 'error', 'message' => $verifyToken], 200);
        }
    }
}