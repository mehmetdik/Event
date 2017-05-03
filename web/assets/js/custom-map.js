var mapStyles = [{featureType:'water',elementType:'all',stylers:[{hue:'#d7ebef'},{saturation:-5},{lightness:54},{visibility:'on'}]},{featureType:'landscape',elementType:'all',stylers:[{hue:'#eceae6'},{saturation:-49},{lightness:22},{visibility:'on'}]},{featureType:'poi.park',elementType:'all',stylers:[{hue:'#dddbd7'},{saturation:-81},{lightness:34},{visibility:'on'}]},{featureType:'poi.medical',elementType:'all',stylers:[{hue:'#dddbd7'},{saturation:-80},{lightness:-2},{visibility:'on'}]},{featureType:'poi.school',elementType:'all',stylers:[{hue:'#c8c6c3'},{saturation:-91},{lightness:-7},{visibility:'on'}]},{featureType:'landscape.natural',elementType:'all',stylers:[{hue:'#c8c6c3'},{saturation:-71},{lightness:-18},{visibility:'on'}]},{featureType:'road.highway',elementType:'all',stylers:[{hue:'#dddbd7'},{saturation:-92},{lightness:60},{visibility:'on'}]},{featureType:'poi',elementType:'all',stylers:[{hue:'#dddbd7'},{saturation:-81},{lightness:34},{visibility:'on'}]},{featureType:'road.arterial',elementType:'all',stylers:[{hue:'#dddbd7'},{saturation:-92},{lightness:37},{visibility:'on'}]},{featureType:'transit',elementType:'geometry',stylers:[{hue:'#c8c6c3'},{saturation:4},{lightness:10},{visibility:'on'}]}];

$.ajaxSetup({
    cache: true
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Google Map - Homepage
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function createHomepageGoogleMap(_latitude,_longitude){
    if( document.getElementById('map') != null ){
        $.getScript("assets/js/locations.js", function(){
            var map = new google.maps.Map(document.getElementById('map'),{
                zoom: 15,
                zoomControl: true,
                streetViewControl: true,
                zoomControlOptions:{
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
                streetViewControlOptions:{
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
                scrollwheel: false,
                center: new google.maps.LatLng(_latitude, _longitude)
            });
            var i;
            var newMarkers = [];
            for (i = 0; i < locations.length; i++){
                var pictureLabel = document.createElement("img");
                pictureLabel.src = locations[i][7];
                var boxText = document.createElement("div");
                infoboxOptions = {
                    content: boxText,
                    disableAutoPan: false,
                    pixelOffset: new google.maps.Size(-100, 0),
                    zIndex: null,
                    alignBottom: true,
                    boxClass: "infobox-wrapper",
                    enableEventPropagation: true,
                    closeBoxMargin: "0px 0px -8px 0px",
                    closeBoxURL: "assets/img/close-btn.png",
                    infoBoxClearance: new google.maps.Size(1, 1)
                };
                var marker = new MarkerWithLabel({
                    title: locations[i][0],
                    position: new google.maps.LatLng(locations[i][3], locations[i][4]),
                    map: map,
                    labelContent: '<div class="marker-loaded"><div class="map-marker"><img src="' + locations[i][7] + '" alt="" /></div></div>',
                    labelAnchor: new google.maps.Point(50, 0),
                    labelClass: "marker-style"
                });
                newMarkers.push(marker);
                boxText.innerHTML =
                '<div class="infobox-inner">' +
                '<a href="' + locations[i][5] + '">' +
                '<div class="infobox-image" style="position: relative">' +
                '<img src="' + locations[i][6] + '">' + '<div><span class="infobox-price">' + locations[i][2] + '</span></div>' +
                '</div>' +
                '</a>' +
                '<div class="infobox-description">' +
                '<div class="infobox-title"><a href="'+ locations[i][5] +'">' + locations[i][0] + '</a></div>' +
                '<div class="infobox-location">' + locations[i][1] + '</div>' +
                '</div>' +
                '</div>';
                //Define the infobox
                newMarkers[i].infobox = new InfoBox(infoboxOptions);
                google.maps.event.addListener(marker, 'click', (function(marker, i){
                    return function(){
                        for (h = 0; h < newMarkers.length; h++){
                            newMarkers[h].infobox.close();
                        }
                        newMarkers[i].infobox.open(map, this);
                    }
                })(marker, i));
            }

            // Autocomplete
            if ($("#address-map").length) {
                var input = ( document.getElementById('address-map') );
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo('bounds', map);
                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    var place = autocomplete.getPlace();
                    if (!place.geometry) {
                        return;
                    }
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(15);
                    }
                    var address = '';
                    if (place.address_components) {
                        address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                        ].join(' ');
                    }
                });
            }
        });
    }
}





