<?php

namespace resources\php;

class KmlMap {

    /**
     * @var
     */
    private $attrs;

    /**
     * Instantiate a KmlMap class
     *
     * @param $attrs
     */
    public function __construct($attrs)
    {
        $this->attrs = $attrs;
    }

    /**
     * Load the necessary js files
     */
    public function load_scripts()
    {
        wp_enqueue_script('googleMapScript', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAb7AEhjwUmKffgccsRbxUjVWa-6KAVBK4', array('jquery'), '', true);
        wp_enqueue_script('app', plugins_url('/wordpress-kml-shortcode/resources/js/app.min.js'), array('jquery'), '', true);
    }

    /**
     * Display the kml map
     *
     * @return string
     */
    public function display_map()
    {
        $args = shortcode_atts(
            array(
                'name' => '74211',
                'coordinates' => '42.811609,-7.5764603',
                'zoom' => '8',
                'width' => '100%',
                'height' => '300px'
            ), $this->attrs
        );

        extract($args);
        $coords = explode( ',', $coordinates);

        $zoom = (int) $zoom;

        return "<div id='$name'
                     class='kml-map'
                     data-lat='$coords[0]'
                     data-lng='$coords[1]'
                     data-zoom='$zoom'
                     data-width='$width'
                     data-height='$height'
               >
               </div>"
        ;
    }
}