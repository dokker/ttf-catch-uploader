(function($) {

acf.add_action('load', function () {
    var googleMap = acf.fields.google_map;
    var interval = setInterval(function () {
        if (googleMap.status !== 'ready') {
            return;
        }
        clearInterval(interval);
        // Set all the google maps type to HYBRID
        $.each(googleMap.maps, (keyName, map) => {
            map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
        });
    }, 100);
});

})(jQuery);
