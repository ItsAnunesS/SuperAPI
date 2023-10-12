<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Api_Anuness_Dev_Links_Post_Type extends Api_Anuness_Dev_Custom_Post_Type
{
    protected function get_post_type()
    {
        return 'links';
    }

    protected function get_post_type_args()
    {
        $args = array(
            'labels'      => array(
                'name'          => __('Links', 'api-anuness-dev'),
                'singular_name' => __('Link', 'api-anuness-dev'),
            ),
            'public'      => true,
            'has_archive' => false,
            'rewrite'     => array(
                'slug' => $this->get_post_type()
            ),
            'supports'    => array('title'),
        );

        return $args;
    }

    public function register_meta_boxes()
    {
        $list_models = Api_Anuness_Dev_OpenAI::list_models();
        Container::make('post_meta', 'Chat Details')
            ->where('post_type', '=', $this->get_post_type())
            ->add_fields(
                array(
                    Field::make('select', 'chat_model', __('Chat Model', 'api-anuness-dev'))
                        ->set_options(
                            $list_models
                        )
                        ->set_required(true),
                    Field::make('text', 'chat_temperature', __('Chat Temperature', 'api-anuness-dev'))
                        ->set_required(true)
                        ->set_default_value(1.0)
                        ->set_attribute('type', 'number'),
                    Field::make('text', 'chat_max_tokens', __('Chat Max Tokens', 'api-anuness-dev'))
                        ->set_required(true)
                        ->set_default_value(1500)
                        ->set_attribute('type', 'number'),
                    Field::make('text', 'chat_frequency_penalty', __('Chat Frequency Penalty', 'api-anuness-dev'))
                        ->set_required(true)
                        ->set_default_value(0.0)
                        ->set_attribute('type', 'number'),
                    Field::make('text', 'chat_presence_penalty', __('Chat Presence Penalty', 'api-anuness-dev'))
                        ->set_required(true)
                        ->set_default_value(0.6)
                        ->set_attribute('type', 'number'),
                    Field::make('complex', 'chat_messages', __('Chat Messages', 'api-anuness-dev'))
                        ->add_fields(
                            array(
                                Field::make('textarea', 'prompt', __('Prompt', 'api-anuness-dev'))
                                    ->set_required(true)
                                    ->set_attribute('readOnly', true)
                                    ->set_rows(3),
                                Field::make('text', 'role', __('Role', 'api-anuness-dev'))
                                    ->set_required(true)
                                    ->set_attribute('readOnly', true)
                                    ->set_default_value('User'),
                                Field::make('textarea', 'content', __('Content', 'api-anuness-dev'))
                                    ->set_required(true)
                                    ->set_attribute('readOnly', true)
                                    ->set_rows(3),
                                Field::make('text', 'model', __('Model', 'api-anuness-dev'))
                                    ->set_required(true)
                                    ->set_attribute('readOnly', true)
                                    ->set_default_value(''),
                                Field::make('text', 'temperature', __('Temperature', 'api-anuness-dev'))
                                    ->set_required(true)
                                    ->set_attribute('readOnly', true)
                                    ->set_default_value(''),
                                Field::make('text', 'max_tokens', __('Max Tokens', 'api-anuness-dev'))
                                    ->set_required(true)
                                    ->set_attribute('readOnly', true)
                                    ->set_default_value(''),
                                Field::make('text', 'frequency_penalty', __('Frequency Penalty', 'api-anuness-dev'))
                                    ->set_required(true)
                                    ->set_attribute('readOnly', true)
                                    ->set_default_value(''),
                                Field::make('text', 'presence_penalty', __('Presence Penalty', 'api-anuness-dev'))
                                    ->set_required(true)
                                    ->set_attribute('readOnly', true)
                                    ->set_default_value(''),
                            )
                        )
                        ->set_layout('grid')
                        ->set_header_template(
                            '<% if (role) { %>
                                <%- role %><% if (prompt) { %> : <%- prompt.substring(0,20) %>...<% } %>
                            <% } %>'
                        )
                        ->set_duplicate_groups_allowed(false),
                )
            );
    }
}
