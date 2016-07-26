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

    public $options;

    public function __construct()
    {
        $this->options = get_option('kml_plugin_options');
        $this->register_settings_and_fields();
    }

    public function add_menu_page()
    {
        add_options_page('Kml Options', 'Kml Options', 'administrator', __FILE__, array('KmlOptions', 'display_options_page'));
    }

    public function display_options_page()
    {
        ?>
        <div class="wrap">
            <h1>Kml Options</h1>
            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php settings_fields('kml_plugin_options'); ?>
                <?php do_settings_sections(__FILE__); ?>

                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                </p>
            </form>
        </div>
    <?php
    }

    public function register_settings_and_fields()
    {
        // 3rd param = optional cb
        register_setting('kml_plugin_options', 'kml_plugin_options');

        // id, title of section, cb, which page?
        add_settings_section('kml_section', 'Settings', array($this, 'kml_section_cb'), __FILE__);

        add_settings_field('kml_map_id', 'Map Id: ', array($this, 'kml_map_id_setting'), __FILE__, 'kml_section');
        add_settings_field('kml_map_file', 'Map File: ', array($this, 'kml_map_file_setting'), __FILE__, 'kml_section');
    }

    public function kml_section_cb()
    {
        //
    }

    public function kml_map_id_setting()
    {
        echo "<input name='kml_plugin_options[kml_map_id]' type='text' value='{$this->options['kml_map_id']}'>";
    }

    public function kml_map_file_setting()
    {
        echo '<input type="file">';
    }
}

add_action('admin_menu', function() {

    KmlOptions::add_menu_page();
});

add_action('admin_init', function() {

    new KmlOptions();
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
