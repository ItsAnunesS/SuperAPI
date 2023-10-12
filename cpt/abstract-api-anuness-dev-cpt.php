<?php
abstract class Api_Anuness_Dev_Custom_Post_Type
{
    protected $post_type;

    public function __construct()
    {
        $this->post_type = $this->get_post_type();
    }

    abstract protected function get_post_type();

    public function init()
    {
        $args = $this->get_post_type_args();
        register_post_type($this->post_type, $args);
        if (method_exists($this, 'register_meta_boxes')) $this->register_meta_boxes();
    }

    abstract protected function get_post_type_args();

    public function register_meta_boxes()
    {
        return;
    }
}
