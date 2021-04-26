<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Models\Order;

class OrderController
{
    public static function store()
    {
        $request = Request::formRequest();
        if ((new Order())->insert($request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Order created successfully'], 201);
        }
    }
}