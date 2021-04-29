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
        if (!Auth::verifyToken()) {
            return Response::apiResponse(['status' => 'error', 'message' => 'Unauthenticated. No verified token found'], 403);
        }
        $request = Request::formRequest();
        if (
            !isset($request['product_id']) ||
            !isset($request['product_name']) ||
            !isset($request['quantity']) ||
            !isset($request['price']) ||
            !isset($request['shipping_address'])
        ) {
            return Response::apiResponse(['status' => 'validation_error', 'message' => 'product id, product name, quantity, price & shipping address is required'], 403);
        }
        if ((new Order())->insert($request, Auth::user())) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Order placed successfully. Please wait for our customer care contact.'], 201);
        }
    }
}