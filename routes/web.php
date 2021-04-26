<?php

use app\Controllers\Admin\CategoryController as AdminCategoryController;
use app\Controllers\Admin\OrderController as AdminOrderController;
use app\Controllers\Admin\ProductController as AdminProductController;
use app\Controllers\OrderController;
use app\Controllers\ProductController;
use app\Core\Route;

/*
    Admin Routes
    ----------------------------------------------------------
    Categories Route  ->  index, store, show, update, destroy
    Products Route    ->  index, store, show, update, destroy
    Orders Route      ->  index, show, update, destroy
*/
Route::get('/admin/categories', [AdminCategoryController::class, 'index']);
Route::post('/admin/categories', [AdminCategoryController::class, 'store']);
Route::get('/admin/categories/show', [AdminCategoryController::class, 'show']);
Route::patch('/admin/categories/edit', [AdminCategoryController::class, 'update']);
Route::delete('/admin/categories/delete', [AdminCategoryController::class, 'destroy']);

Route::get('/admin/products', [AdminProductController::class, 'index']);
Route::post('/admin/products', [AdminProductController::class, 'store']);
Route::get('/admin/products/show', [AdminProductController::class, 'show']);
Route::patch('/admin/products/edit', [AdminProductController::class, 'update']);
Route::delete('/admin/products/delete', [AdminProductController::class, 'destroy']);

Route::get('/admin/orders', [AdminOrderController::class, 'index']);
Route::get('/admin/orders/show', [AdminOrderController::class, 'show']);
Route::patch('/admin/orders/edit', [AdminOrderController::class, 'update']);
Route::delete('/admin/orders/delete', [AdminOrderController::class, 'destroy']);

/*
    User Routes
    ----------------------------------------------------------
    Products Route  ->  index, show
    Orders Route    ->  show
*/
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/show', [ProductController::class, 'show']);

Route::post('/orders', [OrderController::class, 'store']);