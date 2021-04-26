<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Models\Product;

class ProductController
{
    public static function index()
    {
        $products = (new Product())->all();
        $count = count($products);
        return Response::apiResponse(['status' => 'done', 'products' => $products, 'count' => $count], 200);
    }

    public static function show()
    {
        $request = Request::formRequest();
        $product = (new Product())->find($request['id']);
        return Response::apiResponse(['status' => 'done', 'product' => $product], 200);
    }
}