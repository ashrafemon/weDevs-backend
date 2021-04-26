<?php

namespace app\Core;


class Application
{
    public Route $route;

    public function __construct()
    {
        $this->route = new Route();
    }

    public function run()
    {
        echo $this->route->resolve();
    }
}