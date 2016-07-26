<?php
/*
Plugin Name: WP Kml Shortcode
Plugin URI: https://github.com/salvesvence/wordpress-kml-shortcode
Description: Shortcode to load a kml map into your Wordpress Theme.
Version: 1.0
Author: Silvano Alves Vence
Author URI: https://github.com/salvesvence
*/

class KmlOptions {

    public function __construct()
    {

    }

    public function add_menu_page()
    {
        add_options_page('Kml Options', 'Kml Options', 'manage_options', __FILE__, array('KmlOptions', 'display_options_page'));
    }

    public function display_options_page()
    {
        ?>
        <div class="wrap">
            <h1>Kml Options</h1>
            <form method="post" action="options.php" enctype="multipart/form-data"></form>
        </div>
    <?php
    }
}

add_action('admin_menu', function() {

    KmlOptions::add_menu_page();
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
