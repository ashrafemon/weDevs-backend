<?php


namespace app\Controllers\Admin;


use app\Core\Request;
use app\Core\Response;
use app\Models\Category;

class CategoryController
{
    public static function index()
    {
        $categories = (new Category())->all();
        $count = count($categories);
        return Response::apiResponse(['status' => 'done', 'categories' => $categories, 'count' => $count], 200);
    }

    public static function store()
    {
        $request = Request::formRequest();
        if ((new Category())->insert($request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Category created successfully'], 201);
        }
    }

    public static function show()
    {
        $request = Request::formRequest();
        $category = (new Category())->find($request['id']);
        return Response::apiResponse(['status' => 'done', 'category' => $category], 200);
    }

    public static function update()
    {
        $request = Request::formRequest();
        if ((new Category())->update($request['id'], $request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Category updated successfully'], 202);
        }
    }

    public static function destroy()
    {
        $request = Request::formRequest();
        if ((new Category())->delete($request['id'])) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Category deleted successfully'], 202);
        }
    }
}