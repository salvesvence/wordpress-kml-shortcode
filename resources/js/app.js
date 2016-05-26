jQuery(document).on('shown.bs.collapse shown.bs.tab', '.panel-collapse, a[data-toggle="tab"]', function () {

    var segments    =   window.location.pathname.split('/')[3],
        segment     =   segments.split('-'),
        baseUrl     =   window.location.protocol + '//' + window.location.host,
        div         =   jQuery('#' + segments);

    function initMap() {

        div.css('height', div.data('height'));

        var map = new google.maps.Map(document.getElementById(segments), {
            center: { lat: div.data('lat'), lng: div.data('lng') },
            zoom: div.data('zoom'),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var myParser = new geoXML3.parser({
            map: map,
            processStyles: true,
            zoom : false
        });

        myParser.parse(baseUrl + '/wp-content/resources/kml/' + segment[ segment.length - 1 ] + '.kml');
    }

    initMap();
});