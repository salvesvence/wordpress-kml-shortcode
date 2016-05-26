<?php
/*
Plugin Name: WP Kml Shortcode
Plugin URI: https://github.com/salvesvence/wordpress-kml-shortcode
Description: Shortcode to load a kml map into your Wordpress Theme.
Version: 1.0
Author: Silvano Alves Vence
Author URI: https://github.com/salvesvence
*/

add_shortcode('kml_map', function($attrs) {

    $args = shortcode_atts(
        array(
            'name' => 'via-de-la-plata-74211',
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