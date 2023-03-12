<?php
require(MY_PLUGIN_PATH . "/vendor/autoload.php");

if (!defined('ABSPATH')) {
      die('You cannot be here');
}

add_shortcode('greetings', 'show_greetings_form');

add_action('rest_api_init', 'create_rest_endpoint');

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function enqueue_custom_scripts()
{

      // Enqueue custom css for plugin

      wp_enqueue_style('greetings-form-plugin', MY_PLUGIN_URL . 'assets/css/greetings-plugin.css');
}

function show_greetings_form()
{
      include MY_PLUGIN_PATH . '/includes/templates/greetings-form.php';
}

function create_rest_endpoint()
{

      // Create endpoint for front end to connect to WordPress securely to post form data
      register_rest_route('v1/greetings-form', 'submit', array(

            'methods' => 'POST',
            'callback' => 'handle_enquiry'

      ));

      register_rest_route('v1/greetings-form', 'settings', array(

            'methods' => 'POST',
            'callback' => 'handle_settings'

      ));
}


function handle_enquiry($data)
{
      // Handle the form data that is posted

      // Get all parameters from form
      $params = $data->get_params();

      // Set fields from the form
      $field_greeting = sanitize_text_field($params['greeting']);

      // Check if nonce is valid, if not, respond back with error
      if (!wp_verify_nonce($params['_wpnonce'], 'wp_rest')) {

            return new WP_Rest_Response('Greeting not sent', 422);

      }

      $url = 'https://ibl-theme.localhost/wp-json/v1/greetings-form/settings';
      
      $response = wp_remote_post( $url, array('sslverify' => false, 'headers'=>array('Authorization'=>"Bearer xotc8tlhu5osvhi06lxksexdruy80d7jkt8fhxbj", "Content-Type"=>"application/json", 'body'=>array('greeting'=>$field_greeting))) );
      $body = wp_remote_retrieve_body( $response );
      return new WP_Rest_Response($response, 200);
}

function handle_settings($data)
{
      // Handle the form data that is posted

      // Get all parameters from form
      $params = $data->get_params();

      // Set fields from the form
      $field_greeting = sanitize_text_field($params['greeting']);
      set_plugin_options('greetings_plugin_greeting', $field_greeting);
      $response = get_plugin_options('greetings_plugin_greeting');
      return new WP_Rest_Response($response, 200);
}
