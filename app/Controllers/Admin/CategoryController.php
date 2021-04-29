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
        if (!isset($request['name'])) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'name field is required'], 403);
        }
        if ((new Category())->insert($request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Category created successfully'], 201);
        }
    }

    public static function show()
    {
        $request = Request::formRequest();
        if (!isset($request['id'])) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'id is required'], 201);
        }
        $category = (new Category())->find($request['id']);
        if (!$category) {
            return Response::apiResponse(['status' => 'error', 'message' => 'There is no category...'], 404);
        }
        return Response::apiResponse(['status' => 'done', 'category' => $category], 200);
    }

    public static function update()
    {
        $request = Request::formRequest();
        if (!isset($request['id']) || !isset($request['name'])) {
            return Response::apiResponse(['status' => 'validation_error', 'errors' => 'id and name field is required'], 403);
        }
        $category = (new Category())->find($request['id']);
        if (!$category) {
            return Response::apiResponse(['status' => 'error', 'message' => 'There is no category...'], 404);
        }
        if ((new Category())->update($request['id'], $request)) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Category updated successfully'], 202);
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
        $category = (new Category())->find($request['id']);
        if (!$category) {
            return Response::apiResponse(['status' => 'error', 'message' => 'There is no category...'], 404);
        }
        if ((new Category())->delete($request['id'])) {
            return Response::apiResponse(['status' => 'done', 'message' => 'Category deleted successfully'], 202);
        }
    }
}