var kml         =   jQuery('.kml-map').attr('id'),
    id          =   kml.split('-'),
    baseUrl     =   window.location.protocol + '//' + window.location.host,
    div         =   jQuery('#' + kml);

function initMap() {

    var hasContainer = div.parent().attr('class') === 'tours-tabs__content padding-all';

    div.css({
        'height': div.data('height'),
        'margin-bottom': hasContainer ? '0' : '30px',
        'box-shadow': hasContainer ? 'none' : '0 2px 3px rgba(0,0,0,0.09)'
    });

    var map = new google.maps.Map(document.getElementById(kml), {
        center: { lat: div.data('lat'), lng: div.data('lng') },
        zoom: div.data('zoom'),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var myParser = new geoXML3.parser({
        map: map,
        processStyles: true,
        zoom : false
    });

    jQuery('.product-category__description > .kml-map').hide();

    myParser.parse(baseUrl + '/wp-content/plugins/wordpress-kml-shortcode/resources/kml/' + kml + '.kml');
}

(function() {

    initMap();

})();

jQuery(document).on('shown.bs.collapse shown.bs.tab', '.panel-collapse, a[data-toggle="tab"]', function () {

    initMap();
});