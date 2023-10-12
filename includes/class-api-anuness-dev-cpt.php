<?php

class Api_Anuness_Dev_CPT
{
    private $cpt_base_dir;

    public function __construct($cpt_base_dir)
    {
        $cpts_class_file = API_ANUNESS_DEV_PLUGIN_DIR . 'cpt/abstract-api-anuness-dev-cpt.php';

        if (!file_exists($cpts_class_file)) new WP_Error('api_anuness_dev_cpt_class_file_not_found', 'CPT class file not found');

        require_once $cpts_class_file;

        $this->cpt_base_dir = $cpt_base_dir;
    }

    public function init()
    {
        $cpt_files = glob($this->cpt_base_dir . '/class-api-anuness-dev-*.php');

        if (empty($cpt_files)) return;

        foreach ($cpt_files as $cpt_file) {
            if (!file_exists($cpt_file)) continue;

            require_once $cpt_file;
            $cpt_class_name = $this->get_cpt_class_name($cpt_file);

            if (class_exists($cpt_class_name)) {
                $cpt_class = new $cpt_class_name();
                $cpt_class->init();
            }
        }
    }

    private function get_cpt_class_name($cpt_file)
    {
        $cpt_name = basename($cpt_file, '.php');
        $cpt_name = str_replace('class-api-anuness-dev-', '', $cpt_name);
        $cpt_name = str_replace('-', '_', $cpt_name);
        $cpt_name = 'Api_Anuness_Dev_' . ucfirst($cpt_name) . '_Post_Type';

        if (!class_exists($cpt_name)) new WP_Error('api_anuness_dev_cpt_class_not_found', 'CPT class not found');

        return $cpt_name;
    }
}
