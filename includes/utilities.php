<?php

if( !defined('ABSPATH') )
{
      die('You cannot be here');
}

function get_plugin_options($name)
{
      return carbon_get_theme_option( $name );
}

function set_plugin_options($name, $value)
{
      return carbon_set_theme_option( $name, $value );
}