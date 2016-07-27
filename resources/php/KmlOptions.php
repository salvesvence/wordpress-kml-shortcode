<?php

namespace resources\php;

class KmlOptions {

    public $options;

    /**
     * Instantiate a KmlOptions class
     */
    public function __construct()
    {
        $this->options = get_option('kml_plugin_options');
        $this->options['kml_map_id'] = sanitize_title($this->options['kml_map_id']);

        $this->register_settings_and_fields();
    }

    /**
     * Add the Kml Options page
     */
    public function add_menu_page()
    {
        add_options_page('Kml Options', 'Kml Options', 'administrator', __FILE__, array('resources\php\KmlOptions', 'display_options_page'));
    }

    /**
     * Displays the options of the Kml Options page
     */
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

    /**
     * Register all Kml Options page settings and fields.
     */
    public function register_settings_and_fields()
    {
        // 3rd param = optional cb
        register_setting('kml_plugin_options', 'kml_plugin_options', array($this, 'kml_validate_settings'));

        // id, title of section, cb, which page?
        add_settings_section('kml_section', 'Settings', array($this, 'kml_section_cb'), __FILE__);

        add_settings_field('kml_map_id', 'Map Id: ', array($this, 'kml_map_id_setting'), __FILE__, 'kml_section');
        add_settings_field('kml_map_file', 'Map File: ', array($this, 'kml_map_file_setting'), __FILE__, 'kml_section');
    }

    /**
     *
     */
    public function kml_section_cb()
    {
        //
    }

    /**
     * Validate settings
     *
     * @param $plugin_options
     * @return mixed
     */
    public function kml_validate_settings($plugin_options)
    {
        $extension = 'application/octet-stream';

        if( !empty($_FILES['map_file']['tmp_name']) && $_FILES['map_file']['type'] === $extension) {

            $filename = $this->options['kml_map_id'];
            $plugin_options['kml_map_file'] = $filename;

            $path = __DIR__ . '/resources/kml/' . $filename . '.kml';
            copy($plugin_options['kml_map_file'], $path);
        }
        else {
            $plugin_options['kml_map_file'] = $this->options['kml_map_file'];
        }

        return $plugin_options;
    }

    /**
     * Display the map id setting into the Kml Options page.
     */
    public function kml_map_id_setting()
    {
        echo "<input name='kml_plugin_options[kml_map_id]' type='text' value='{$this->options['kml_map_id']}'>";
    }

    /**
     * Display the map files setting into the Kml Options page.
     */
    public function kml_map_file_setting()
    {
        echo '<input name="map_file" type="file"><br><br>';
    }
}