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
require_once plugin_dir_path( __FILE__ ) . 'resources/php/KmlMap.php';

add_action('admin_menu', function() {
    resources\php\KmlOptions::add_menu_page();
});

add_action('admin_init', function() {
    new resources\php\KmlOptions();
});

add_shortcode('kml_map', function($attrs) {
    $kmlMap = new resources\php\KmlMap($attrs);
    $kmlMap->load_scripts();

    return $kmlMap->display_map();
});
