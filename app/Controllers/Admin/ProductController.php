<?php

namespace app\Controllers\Admin;

use app\Core\Request;
use app\Core\Response;
use app\Models\Product;
use Cloudinary\Api\Upload\UploadApi;


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
        if (
            !isset($request['name']) ||
            !isset($request['description']) ||
            !isset($request['category_id']) ||
            !isset($request['category_name']) ||
            !isset($request['price'])
        ) {
            return Response::apiResponse(['status' => 'validation_error', 'message' => 'name, description, category_id, category_name & price is required'], 403);
        }
        $request['sku'] = strtoupper(uniqid('SKU_'));
        if ((new Product())->insert($request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Product created successfully'], 201);
        }
    }

    public static function upload_image()
    {
        if (!isset($_FILES['image'])) {
            return Response::apiResponse(['status' => 'validation_error', 'message' => 'image field is required'], 403);
        }
        try {
            $imageUrl = (new UploadApi())->upload($_FILES['image']['tmp_name'], ['folder' => 'we-dev-store/products/', 'public_id' => 'product-' . uniqid(100), 'overwrite' => true, 'resource_type' => 'image']);
            return Response::apiResponse(['status' => 'done', 'image_url' => $imageUrl['url']], 201);
        } catch (\Exception $e) {
            return Response::apiResponse(['status' => 'error', 'message' => 'Server Error. ' . $e->getMessage()], 500);
        }
    }

    public static function show()
    {
        $request = Request::formRequest();
        if (!isset($request['id'])) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'id is required'], 403);
        }
        $product = (new Product())->find($request['id']);
        if (!$product) {
            return Response::apiResponse(['status' => 'error', 'message' => 'There is no product...'], 404);
        }
        return Response::apiResponse(['status' => 'done', 'product' => $product], 200);
    }

    public static function update()
    {
        $request = Request::formRequest();
        if (!isset($request['id'])) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'id and name field is required'], 403);
        }
        $product = (new Product())->find($request['id']);
        if (!$product) {
            return Response::apiResponse(['status' => 'error', 'message' => 'There is no product...'], 404);
        }
        if ((new Product())->update($request['id'], $request, $product)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Product updated successfully'], 202);
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
        $product = (new Product())->find($request['id']);
        if (!$product) {
            return Response::apiResponse(['status' => 'error', 'message' => 'There is no product...'], 404);
        }
        if ((new Product())->delete($request['id'])) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Product deleted successfully'], 202);
        }
    }
}