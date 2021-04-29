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
        if (!isset($request['id'])) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'id is required'], 403);
        }
        $order = (new Order())->find($request['id']);
        if (!$order) {
            return Response::apiResponse(['status' => 'error', 'message' => 'There is no order...'], 404);
        }
        return Response::apiResponse(['status' => 'done', 'order' => $order], 200);
    }

    public static function update()
    {
        $request = Request::formRequest();
        if (!isset($request['id'])) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'id is required'], 403);
        }
        $order = (new Order())->find($request['id']);
        if (!$order) {
            return Response::apiResponse(['status' => 'error', 'message' => 'There is no order...'], 404);
        }
        if ((new Order())->update($request['id'], $request, $order)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Order updated successfully'], 202);
        } else {
            return Response::apiResponse(['status' => 'error', 'message' => 'No new data added'], 403);
        }
    }

    public static function destroy()
    {
        $request = Request::formRequest();
        if (!isset($request['id'])) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'id is required'], 403);
        }
        $order = (new Order())->find($request['id']);
        if (!$order) {
            return Response::apiResponse(['status' => 'error', 'message' => 'There is no order...'], 404);
        }
        if ((new Order())->delete($request['id'])) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Order deleted successfully'], 202);
        }
    }
}