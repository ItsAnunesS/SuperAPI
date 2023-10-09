<?php

class Api_Anuness_Dev_Posts extends Api_Anuness_Dev_Endpoints
{
    private $routes = [];

    public function init()
    {
        $this->add_route('/posts', array($this, 'get_posts'));
        $this->add_route('/posts/(?P<id>\d+)', array($this, 'get_post'));
    }

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

    public function get_posts()
    {
        $posts = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => 10
        ));

        $data = array();

        foreach ($posts as $post) {
            $data[] = array(
                'id' => $post->ID,
                'title' => $post->post_title,
                'content' => $post->post_content
            );
        }

        return $data;
    }
}
