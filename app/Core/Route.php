<?php

namespace app\Core;

class Route
{
    public static array $routes = [];

    public static function get($path, $callback)
    {
        self::$routes['get'][$path] = $callback;
    }

    public static function post($path, $callback)
    {
        self::$routes['post'][$path] = $callback;
    }

    public static function patch($path, $callback)
    {
        self::$routes['patch'][$path] = $callback;
    }

    public static function delete($path, $callback)
    {
        self::$routes['delete'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->getPath();
        $method = $this->getMethod();
        $callback = self::$routes[$method][$path] ?? false;
        if ($callback) {
            return call_user_func($callback);
        } else {
            return "No routes found";
        }
    }

    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $paramsPos = strpos($path, '?');
        if ($paramsPos) {
            return substr($path, 0, $paramsPos);
        }
        return $path;
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}