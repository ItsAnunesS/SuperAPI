<?php

use Orhanerday\OpenAi\OpenAi;

class Api_Anuness_Dev_OpenAI
{
    private static $open_ai;
    private static $instance;

    public function __construct()
    {
        $open_ai_key = get_option('_api_anuness_dev_openai_key', false);

        if (empty($open_ai_key)) {
            throw new Exception('OpenAI key not found');
        }

        self::$open_ai = new OpenAi($open_ai_key);
    }

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get_open_ai()
    {
        return self::$open_ai;
    }

    public static function list_models()
    {
        $instance = self::get_instance();
        $open_ai  = $instance->get_open_ai();
        $response = $open_ai->listModels();
        $response = json_decode($response, true);
        $response = $response['data'];

        if (empty($response)) return array();

        return self::parse_models($response);
    }

    public static function parse_models($models)
    {
        $parsed_models = array();

        foreach ($models as $model) {
            $model_id   = $model['id'];
            $model_name = $model['root'];

            if (empty($model_id) || empty($model_name) || strpos($model_name, 'gpt') !== 0) continue;

            $parsed_models[$model_id] = $model_name;
        }

        return $parsed_models;
    }
}
