<?php

/*
Plugin Name: WP Kml Shortcode
Plugin URI: https://github.com/salvesvence/wordpress-kml-shortcode
Description: Shortcode to load a kml map into your Wordpress Theme.
Version: 1.0
Author: Silvano Alves Vence
Author URI: https://github.com/salvesvence
*/

require_once plugin_dir_path( __FILE__ ) . 'resources/php/KmlOptions.php';

add_action('admin_menu', function() {

    resources\php\KmlOptions::add_menu_page();
});

add_action('admin_init', function() {

    new resources\php\KmlOptions();
});

add_shortcode('kml_map', function($attrs) {

    wp_enqueue_script('googleMapScript', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAb7AEhjwUmKffgccsRbxUjVWa-6KAVBK4', array('jquery'), '', true);
    wp_enqueue_script('app', plugins_url('/wordpress-kml-shortcode/resources/js/app.min.js'), array('jquery'), '', true);

    $args = shortcode_atts(
        array(
            'name' => '74211',
            'coordinates' => '42.811609,-7.5764603',
            'zoom' => '8',
            'width' => '100%',
            'height' => '300px'
        ), $attrs
    );

    extract($args);

    $coords = explode( ',', $coordinates);
    $zoom = (int) $zoom;

    return "<div id='$name' class='kml-map' data-lat='$coords[0]' data-lng='$coords[1]' data-zoom='$zoom' data-width='$width' data-height='$height'></div>";
});
