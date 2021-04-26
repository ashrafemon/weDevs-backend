<?php

namespace app\Controllers\Admin;

use app\Core\Request;
use app\Core\Response;
use app\Models\Order;

class OrderController
{
    public static function index()
    {
        $orders = (new Order())->all();
        $count = count($orders);
        return Response::apiResponse(['status' => 'done', 'orders' => $orders, 'count' => $count], 200);
    }

    public static function show()
    {
        $request = Request::formRequest();
        $order = (new Order())->find($request['id']);
        return Response::apiResponse(['status' => 'done', 'order' => $order], 200);
    }

    public static function update()
    {
        $request = Request::formRequest();
        if ((new Order())->update($request['id'], $request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Order updated successfully'], 202);
        }
    }

    public static function destroy()
    {
        $request = Request::formRequest();
        if ((new Order())->delete($request['id'])) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Order deleted successfully'], 202);
        }
    }
}