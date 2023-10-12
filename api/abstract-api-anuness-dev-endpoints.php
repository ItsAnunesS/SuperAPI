<?php

abstract class Api_Anuness_Dev_Endpoints
{
    private $routes = [];

    abstract public function init();

    public function get_routes()
    {
        return $this->routes;
    }

    protected function add_route($route, $callback)
    {
        $this->routes[$route] = array(
            'methods'  => 'GET',
            'callback' => $callback,
            'permission_callback' => '__return_true'
        );
    }
}
