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
        $image = $_FILES['image'];

        $request['sku'] = strtoupper(uniqid('SKU_'));
        $request['image'] = self::upload_image($image);

        if ((new Product())->insert($request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Product created successfully'], 201);
        }
    }

    public static function upload_image($image)
    {
        if ($image) {
            try {
                $imageUrl = (new UploadApi())->upload($image['tmp_name'], ['folder' => 'we-dev-store/products/', 'public_id' => 'product-', 'overwrite' => true, 'resource_type' => 'image']);
                return $imageUrl['url'];
            } catch (\Exception $e) {
                exit($e->getMessage());
            }
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
        $image = $_FILES['image'];
        $request['image'] = self::upload_image($image);

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