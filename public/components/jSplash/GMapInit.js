// ------------------------ Init Google Maps for appsker ------------------------ //
(function ( $ ) {
    $.fn.GMapInit = function(options) {
        // this=$(this); //--!important

        var defaults = {
            loc: {
                lat: 32.0853,
                lng: 34.7817676
            },
            mapOptions : {
                zoom: 4,
                mapTypeControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            },
            markers: [],               // array of coords
            searchBox: false,          // OR html id
            locationBox: false,        // OR html id
            radiusControl: false,      // OR html id
            radiusOptions: {min:50,step:10,max:99999990},
            searchBoxHighlignt: {      // object of html ids
                lat: 'loc-lat',
                lng: 'loc-lng',
                syncOnInit:false               //add marker at first run
            }
        };
        this.gmopt = $.extend(defaults, options);
        this.markers = [];

        this.radius = false;
        this.radiusCircle = null;

        var startOptions = {
            zoom: 4,
            center: new google.maps.LatLng(this.gmopt.loc.lat, this.gmopt.loc.lng),
            mapTypeControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        startOptions = $.extend(startOptions, this.gmopt.mapOptions);

        this.map = new google.maps.Map(this.get(0), startOptions);

        this.markerManager = new MarkerClusterer(this.map);

        google.maps.event.addListenerOnce(this.map, "idle", function (GMap) {
            return function () {
                google.maps.event.trigger(GMap.map, 'resize');
                GMap.markers.forEach(function (marker) {
                    marker.setMap(null);
                    marker.setMap(GMap.map);
                });
            }
        }(this));

        this.mapLoc = false;
        if (this.gmopt.searchBoxHighlignt) {
            this.mapLoc = [
                (typeof this.gmopt.searchBoxHighlignt.lat=='string') ? document.getElementById(this.gmopt.searchBoxHighlignt.lat) : this.gmopt.searchBoxHighlignt.lat,
                (typeof this.gmopt.searchBoxHighlignt.lng=='string') ? document.getElementById(this.gmopt.searchBoxHighlignt.lng) : this.gmopt.searchBoxHighlignt.lng
            ];
        }
        this.locChange = function(lat,lng){
            $(this.mapLoc[0]).val(lat).change();
            $(this.mapLoc[1]).val(lng).change();
        };

        if (this.gmopt.markers.length) {
            var fixedMarkers = [];
            for (var i = 0; i < this.gmopt.markers.length; i++) {
                var marker_place = new google.maps.LatLng(this.gmopt.markers[i][0], this.gmopt.markers[i][1]);
                var marker = new google.maps.Marker({position: marker_place});
                var circle = new google.maps.Circle({
                    strokeColor: '#0000ff',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#0000ff',
                    fillOpacity: 0.35,
                    center: marker_place,
                    radius: 100.000
                });
                //circle.setMap(this.map);
                fixedMarkers.push(marker);
            }
            this.markerManager.addMarkers(fixedMarkers);
        }

        if (this.gmopt.radiusControl) {
            this.radius = document.getElementById(this.gmopt.radiusControl);
            this.radiusCircle = new google.maps.Circle({
                strokeColor: '#00FF00',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#00FF00',
                fillOpacity: 0.35,
                center: new google.maps.LatLng(0, 0),
                radius: 0.000
            });
            this.radiusCircle.setMap(this.map);
            $(this.radius).change(function(GMap) {
                return function() {
                    if(this.value < GMap.gmopt.radiusOptions.min) {this.value=GMap.gmopt.radiusOptions.min; }
                    if(this.value > GMap.gmopt.radiusOptions.max) {this.value=GMap.gmopt.radiusOptions.max; }
                    this.value = parseInt(this.value/GMap.gmopt.radiusOptions.step)*GMap.gmopt.radiusOptions.step;

                    GMap.radiusCircle.setRadius(parseInt(this.value));
                }
            }(this));
        };
        if(this.mapLoc && this.gmopt.searchBoxHighlignt.syncOnInit==true) {
            if(isNaN(parseFloat(this.mapLoc[0].value)) && isNaN(parseFloat(this.mapLoc[1].value))) {
                this.gmopt.searchBoxHighlignt.syncOnInit=false;
            } else {
                var coords = new google.maps.LatLng(parseFloat(this.mapLoc[0].value), parseFloat(this.mapLoc[1].value));
                var locMarker = new google.maps.Marker({position: coords});
                locMarker.setMap(this.map);
                this.markers.push(locMarker);
                if (this.radiusCircle) {
                    this.radiusCircle.setCenter(coords);
                    $(this.radius).change();
                }
                this.map.setCenter(coords);
            }
        }

        if (this.gmopt.locationBox) {
            document.getElementById(this.gmopt.locationBox).onchange = function (GMap) {
                return function()
                {
                    // Clear out the old markers.
                    GMap.markers.forEach(function (marker) {
                        marker.setMap(null);
                    });
                    var loc = $(this).val().split(',');
                    if (loc.length != 2) {
                        if (GMap.mapLoc) {
                            GMap.locChange('','');
                        }
                        GMap.radiusCircle.set.radius(0);
                    } else {
                        var coords = new google.maps.LatLng(parseFloat(loc[0]), parseFloat(loc[1]));
                        var locMarker = new google.maps.Marker({position: coords, map: GMap.map});
                        GMap.markers.push(locMarker);

                        if (GMap.mapLoc) {
                            GMap.locChange(coords.lat(),coords.lng());
                        }
                        GMap.radiusCircle.setCenter(coords);
                        $(GMap.radius).change();
                        GMap.map.panTo(coords);
                        //GMap.map.setCenter(coords);
                    }
                }
            }(this);
        }

        if (this.gmopt.searchBox) {
            // Create the search box and link it to the UI element.
            this.input = (typeof this.gmopt.searchBoxHighlignt.lat=='string') ? document.getElementById(this.gmopt.searchBox) : this.gmopt.searchBox;

            this.searchBox = new google.maps.places.SearchBox(this.input);

            // Bias the SearchBox results towards current map's viewport.
            this.map.addListener('bounds_changed', function(GMap) {
                    return function() {  GMap.searchBox.setBounds(GMap.map.getBounds()); }
                }(this));

            // [START region_getplaces]
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            this.searchBox.addListener('places_changed', function(GMap) {
                    return function () {
                        var places = GMap.searchBox.getPlaces();

                        if (places.length == 0) {
                            return;
                        }
                        // Clear out the old markers.
                        GMap.markers.forEach(function (marker) {
                            marker.setMap(null);
                        });
                        GMap.markers = [];

                        // For each place, get the icon, name and location.
                        var bounds = new google.maps.LatLngBounds();
                        places.forEach(function (place) {
                            // Create a marker for each place.
                            var marker = new google.maps.Marker({
                                map: GMap.map,
                                draggable: true,
                                title: place.name,
                                position: place.geometry.location
                            });
                            GMap.markers.push(marker);
                            if(GMap.radiusCircle) GMap.radiusCircle.setCenter(place.geometry.location);
                            if(GMap.radius) $(GMap.radius).change();


                                google.maps.event.addListener(marker, 'dragend', function () {
                                    var geocoder = new google.maps.Geocoder();

                                    geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                                        if (status == google.maps.GeocoderStatus.OK) {
                                            if (results[0]) {
                                                if(GMap.mapLoc.length) {
                                                    GMap.locChange(marker.getPosition().lat(),marker.getPosition().lng());
                                                }
                                                GMap.map.panTo(marker.getPosition());
                                                //GMap.map.setCenter(marker.getPosition());
                                                if(GMap.radiusCircle) GMap.radiusCircle.setCenter(marker.getPosition());
                                            }
                                        }
                                    });
                                });
                                if(GMap.mapLoc.length) {
                                    GMap.locChange(place.geometry.location.lat(),place.geometry.location.lng())
                                }

                            if (place.geometry.viewport) {
                                // Only geocodes have viewport.
                                bounds.union(place.geometry.viewport);
                            } else {
                                bounds.extend(place.geometry.location);
                            }
                        });
                        GMap.map.fitBounds(bounds);
                    }
                }(this)
            );
            // [END region_getplaces]
        }

        return this;
    }
}( jQuery ));
