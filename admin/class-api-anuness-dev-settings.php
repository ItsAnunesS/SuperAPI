<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Api_Anuness_Dev_Settings
{
    private $container = null;

    public function init()
    {
        $this->initialize_container();
        $this->initialize_fields();
    }

    private function initialize_container()
    {
        $this->container = Container::make('theme_options', __('AnunesS Settings', 'api-anuness-dev'));
        $this->container->set_icon('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBVcGxvYWRlZCB0bzogU1ZHIFJlcG8sIHd3dy5zdmdyZXBvLmNvbSwgR2VuZXJhdG9yOiBTVkcgUmVwbyBNaXhlciBUb29scyAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIGZpbGw9IiMwMDAwMDAiIHZlcnNpb249IjEuMSIgaWQ9IkNhcGFfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgDQoJIHdpZHRoPSI4MDBweCIgaGVpZ2h0PSI4MDBweCIgdmlld0JveD0iMCAwIDE3Ni43MjcgMTc2LjcyNyINCgkgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTMyLjU1MSw1MS4zMDFjMy44MjctMi41NzcsOC4wNjItMy44ODksMTIuNTg0LTMuODg5YzkuODEyLDAsMTguMTI4LDYuMDgyLDI2LjE2MSwxMS45NzUNCgkJCWM1Ljg4Nyw0LjI5MiwxMi41NTEsOS4xNzksMTcuMDYyLDkuMTc5YzQuMzcxLDAsMTAuOTM4LTQuOTEyLDE2Ljc0Mi05LjI1NmM4LjAwOS01Ljk4OCwxNi4yOTYtMTIuMTk0LDI2LjE0NC0xMi4xOTQNCgkJCWM0LjQwOSwwLDguNTQ3LDEuMjY1LDEyLjI5NCwzLjc2YzExLjU5MSw3LjcwNywyMC45NiwxOS40MzUsMjguMTI5LDMyLjY1MWMzLjg1NC0xMC4wNiw1Ljg3LTIwLjY4OCw0LjcxMS0zMS43NzYNCgkJCWMtNS4xNjYtNTAuMDk0LTYxLjA2OS00OS4zMTktODguMDE0LTI1LjE0NUM2MS40MTYsMi40MzEsNS41MjcsMS42NTcsMC4zMzQsNTEuNzVjLTEuMTQ5LDExLjA2NSwwLjg2LDIxLjY4MSw0LjY5NiwzMS43MDYNCgkJCUMxMi4wNzYsNzAuNDcsMjEuMjM0LDU4Ljk1LDMyLjU1MSw1MS4zMDF6Ii8+DQoJCTxwYXRoIGQ9Ik02MS42MzUsMTQ5LjAzNmMxNC45MTMsMTAuODQsMjYuNzI5LDE3LjEyOSwyNi43MjksMTcuMTI5czExLjgxMi02LjI4OSwyNi43Mi0xNy4xMjMNCgkJCWMtOC41NDctMy45MjUtMTcuNTkxLTYuNzM4LTI2LjcyLTYuNzM4Qzc5LjIzNywxNDIuMzA0LDcwLjE4OCwxNDUuMTE3LDYxLjYzNSwxNDkuMDM2eiIvPg0KCQk8cGF0aCBkPSJNMTM3LjIwNyw2MC40MDRjLTEzLjk5MS05LjI5Ny0zMC43ODksMTkuNjE4LTQ4Ljg0NCwxOS42MThjLTE4LjMwMywwLTM1LjMwNS0yOC43NzMtNDkuNDAyLTE5LjIzOQ0KCQkJQzE1LjQ0OCw3Ni42NTgsMCwxMTQuOTg5LDAsMTQ1LjQ5NWMwLDQ4Ljc5MywzOS41NjEtMTQuNjM1LDg4LjM2My0xNC42MzVjNDguODAyLDAsODguMzYzLDYzLjQyOCw4OC4zNjMsMTQuNjM1DQoJCQlDMTc2LjcyNywxMTQuNzUzLDE2MS4wMjEsNzYuMjI3LDEzNy4yMDcsNjAuNDA0eiBNNjIuODY0LDExNy4zMzdoLTEzLjcxdjEzLjcxM0gzNi45NzV2LTEzLjcxM0gyMy4yNjJWMTA1LjE2aDEzLjcxM1Y5MS40NTMNCgkJCUg0OS4xNnYxMy43MTNoMTMuNzF2MTIuMTcxSDYyLjg2NHogTTEyMC4yMTMsMTE3LjMzN2MtMy4zNTcsMC02LjA4OC0yLjcyLTYuMDg4LTYuMDgzYzAtMy4zNjksMi43My02LjA5NCw2LjA4OC02LjA5NA0KCQkJYzMuMzYzLDAsNi4wOTUsMi43MjUsNi4wOTUsNi4wOTRDMTI2LjMwOCwxMTQuNjE3LDEyMy41NywxMTcuMzM3LDEyMC4yMTMsMTE3LjMzN3ogTTEzMy43OTYsMTMwLjkxOQ0KCQkJYy0zLjM2OSwwLTYuMDg4LTIuNzMtNi4wODgtNi4wOTRjMC0zLjM1NywyLjcxOS02LjA3Niw2LjA4OC02LjA3NmMzLjM2MywwLDYuMDgzLDIuNzE5LDYuMDgzLDYuMDc2DQoJCQlDMTM5Ljg3OSwxMjguMTg4LDEzNy4xNTksMTMwLjkxOSwxMzMuNzk2LDEzMC45MTl6IE0xMzMuNzk2LDEwMy43NDdjLTMuMzY5LDAtNi4wODgtMi43MTktNi4wODgtNi4wNzZzMi43MTktNi4wODgsNi4wODgtNi4wODgNCgkJCWMzLjM2MywwLDYuMDgzLDIuNzMsNi4wODMsNi4wODhTMTM3LjE1OSwxMDMuNzQ3LDEzMy43OTYsMTAzLjc0N3ogTTE0Ny4zNzksMTE3LjMzN2MtMy4zNjksMC02LjA4OC0yLjcyLTYuMDg4LTYuMDgzDQoJCQljMC0zLjM2OSwyLjcxOS02LjA5NCw2LjA4OC02LjA5NHM2LjA4OCwyLjcyNSw2LjA4OCw2LjA5NEMxNTMuNDY3LDExNC42MTcsMTUwLjc0OCwxMTcuMzM3LDE0Ny4zNzksMTE3LjMzN3oiLz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4=');
        $this->container->set_page_menu_title(__('AnunesS', 'api-anuness-dev'));
        $this->container->set_page_menu_position(2);
        $this->container->set_page_file('anuness_dashboard');
    }

    private function initialize_fields()
    {
        $this->container->add_tab(
            __('General', 'api-anuness-dev'),
            array(
                Field::make('text', 'api_anuness_dev_openai_key', __('OpenAI Key', 'api-anuness-dev'))
                    ->set_attribute('type', 'password')
                    ->set_required(true),
            )
        );

        $this->container->add_tab(
            __('Sites Allowed', 'api-anuness-dev'),
            array(
                Field::make('complex', 'api_anuness_dev_allowed_sites', __('Allowed Site', 'api-anuness-dev'))
                    ->add_fields(
                        array(
                            Field::make('text', 'title', __('Title', 'api-anuness-dev'))
                                ->set_required(true),
                            Field::make('text', 'website', __('Website URL', 'api-anuness-dev'))
                                ->set_attribute('type', 'url')
                                ->set_required(true),
                            Field::make('text', 'staging', __('Staging URL', 'api-anuness-dev'))
                                ->set_attribute('type', 'url')
                                ->set_required(true),
                        )
                    )
                    ->set_duplicate_groups_allowed(true)
                    ->set_header_template(
                        '<% if (title) { %>
                            <%- title %>
                        <% } %>'
                    )
                    ->set_required(true)
            )
        );
    }
}
