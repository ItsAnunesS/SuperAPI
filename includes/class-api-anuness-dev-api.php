<?php

class Api_Anuness_Dev_Api
{
    private $api_prefix = 'superapi/v1';
    private $api_base_dir;

    public function __construct($api_base_dir)
    {
        $endpoints_class_file = API_ANUNESS_DEV_PLUGIN_DIR . 'api/abstract-api-anuness-dev-endpoints.php';

        if (!file_exists($endpoints_class_file)) new WP_Error('api_anuness_dev_endpoints_class_not_found', 'Endpoints class not found');

        require_once $endpoints_class_file;
        $this->api_base_dir = $api_base_dir;
    }

    public function init()
    {
        $api_version_dirs = glob($this->api_base_dir . '*', GLOB_ONLYDIR);

        if (empty($api_version_dirs)) return;

        foreach ($api_version_dirs as $api_version_dir) {
            $controllers_dir = $api_version_dir . '/';
            if (!is_dir($controllers_dir)) continue;

            $this->parse_namespace($api_version_dir);

            $controller_files = glob($controllers_dir . 'class-api-anuness-dev-*.php');

            if (empty($controller_files)) continue;

            foreach ($controller_files as $controller_file) {

                if (!file_exists($controller_file)) continue;

                require_once $controller_file;
                $class_name = $this->get_controller_class_name($controller_file);

                if (class_exists($class_name)) {
                    $instance = new $class_name();
                    $this->register_rest_api_routes($instance);
                }
            }
        }
    }

    private function get_controller_class_name($controller_file)
    {
        $class_name = basename($controller_file);
        $class_name = str_replace('.php', '', $class_name);
        $class_name = str_replace('class-api-anuness-dev-', '', $class_name);
        $class_name = str_replace('-', '_', $class_name);
        $class_name = ucwords($class_name);
        $class_name = str_replace('_', '', $class_name);
        $class_name = str_replace(' ', '', $class_name);
        $class_name = 'Api_Anuness_Dev_' . $class_name;

        if (!class_exists($class_name)) new WP_Error('api_anuness_dev_controller_class_not_found', 'Controller class not found');

        return $class_name;
    }

    private function parse_namespace($version)
    {
        $version = basename($version);
        $version = str_replace('v', '', $version);
        $version = trim($version);
        $this->api_prefix = "spapi/v$version";
    }

    private function register_rest_api_routes($instance)
    {
        $instance->init();
        $routes = $instance->get_routes();

        if (empty($routes)) new WP_Error('api_anuness_dev_routes_not_found', 'Routes not found');

        foreach ($routes as $route => $route_data) {
            if (empty($route_data['callback'])) continue;

            register_rest_route(
                $this->api_prefix,
                $route,
                $route_data
            );
        }
    }
}
