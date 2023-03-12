<?php

if( !defined('ABSPATH') )
{
      die('You cannot be here');
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('after_setup_theme', 'load_carbon_fields');
add_action('carbon_fields_register_fields', 'create_options_page');

function load_carbon_fields()
{
      \Carbon_Fields\Carbon_Fields::boot();
}

function create_options_page()
{
      Container::make('theme_options', __('Greetings Form'))

            ->set_page_menu_position(30)

            ->set_icon('dashicons-media-text')

            ->add_fields(array(

                  Field::make('text', 'greetings_plugin_greeting', __('Greeting'))->set_attribute('placeholder', 'eg. Hello world!')->set_help_text('The greeting message to be displayed on the front-end'),
                  
            ));
}
