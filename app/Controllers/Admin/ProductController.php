<?php

namespace app\Controllers\Admin;

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

    public static function store()
    {
        $request = Request::formRequest();
        $request['sku'] = strtoupper(uniqid('SKU_'));
        if ((new Product())->insert($request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Product created successfully'], 201);
        }
    }

    public static function show()
    {
        $request = Request::formRequest();
        $product = (new Product())->find($request['id']);
        return Response::apiResponse(['status' => 'done', 'product' => $product], 200);
    }

    public static function update()
    {
        $request = Request::formRequest();
        if ((new Product())->update($request['id'], $request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Product updated successfully'], 202);
        }
    }

    public static function destroy()
    {
        $request = Request::formRequest();
        if ((new Product())->delete($request['id'])) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Product deleted successfully'], 202);
        }
    }
}