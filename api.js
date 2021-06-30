ymaps.ready(init);

function init() {
    // Connect search suggestions to the input field.
    var suggestView = new ymaps.SuggestView('suggest'),
        map,
        placemark;

    // When click on the button, start the verification of the entered data.
    $('#address-btn').bind('click', function (e) {
        geocode();
    });

    function geocode() {
        // Take the request from the input field.
        var request = $('#suggest').val();
        // Geocode the entered data.
        ymaps.geocode(request).then(function (res) {
            var obj = res.geoObjects.get(0),
                error, hint;

            if (obj) {
                switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision')) {
                    case 'exact':
                        break;
                    case 'number':
                    case 'near':
                    case 'range':
                        error = 'Неточный адрес, требуется уточнение';
                        hint = 'Уточните номер дома';
                        break;
                    case 'street':
                        error = 'Неполный адрес, требуется уточнение';
                        hint = 'Уточните номер дома';
                        break;
                    case 'other':
                    default:
                        error = 'Неточный адрес, требуется уточнение';
                        hint = 'Уточните адрес';
                }
            } else {
                error = 'Адрес не найден';
                hint = 'Уточните адрес';
            }

            // If the geocoder returns an empty array or an inexact result, then show an error.
            if (error) {
                showError(error);
                showMessage(hint);
            } else {
                showResult(obj);
            }
        }, function (e) {
            console.log(e)
        })

    }
    function showResult(obj) {
        // Remove the error message if the found address matches the search query.
        $('#suggest').parent().removeClass('has-error');
        $('#map').addClass('map');
        $('#notice').css('display', 'none');
        $('#reg-btn').attr("disabled", false);

        var mapContainer = $('#map'),
            bounds = obj.properties.get('boundedBy'),
        // Calculate the visible area for the current position of the user.
            mapState = ymaps.util.bounds.getCenterAndZoom(
                bounds,
                [mapContainer.width(), mapContainer.height()]
            ),
        // Save the full address.
            address = [obj.getCountry(), obj.getAddressLine()].join(', '),
            secondAddress = [obj.getAddressLine()].join(', '),
        // Save the shortened address for the label signature.
            shortAddress = [obj.getThoroughfare(), obj.getPremiseNumber(), obj.getPremise()].join(' ');
        // Remove controls from the map.
        mapState.controls = [];
        // Create a map.
        createMap(mapState, shortAddress);
        var array = secondAddress.split(', ');
        switch (array.length) {
          case 6:
            	$.each(array, function( index, value ) {
                  switch (index) {
                      case 0:
                      	$('#country').val(value);
                        break;
                      case 1:
						$('#region').val(value);
                        break;
                      case 2:
						$('#city-region').val(value);
                        break;
                      case 3:
						$('#city-little').val(value);
                        break;
                      case 4:
						$('#street').val(value);
                        break;
                      default:
						$('#house').val(value);
                    }
                });
            break;
          case 5:
            	$.each(array, function( index, value ) {
                  switch (index) {
                      case 0:
                      	$('#country').val(value);
                        break;
                      case 1:
						$('#region').val(value);
                        break;
                      case 2:
						$('#city').val(value);
                        break;
                      case 3:
						$('#street').val(value);
                        break;
                      default:
						$('#house').val(value);
                    }
                });
            break;
          default:
            	$.each(array, function( index, value ) {
                  switch (index) {
                      case 0:
                      	$('#country').val(value);
                        break;
                      case 1:
						$('#city').val(value);
                        break;
                      case 2:
						$('#street').val(value);
                        break;
                      default:
						$('#house').val(value);
                    }
                });
        }
    }

    function showError(message) {
        $('#notice').text(message);
        $('#suggest').parent().addClass('has-error');
        $('#map').removeClass('map');
        $('#notice').css('display', 'block');
        $('#reg-btn').attr("disabled", true);
        // Remove the map.
        if (map) {
            map.destroy();
            map = null;
        }
    }

    function createMap(state, caption) {
        // If the map has not been created yet, then will create it and add a label with the address.
        if (!map) {
            map = new ymaps.Map('map', state);
            placemark = new ymaps.Placemark(
                map.getCenter(), {
                    iconCaption: caption,
                    balloonContent: caption
                }, {
                    preset: 'islands#redDotIconWithCaption'
                });
            map.geoObjects.add(placemark);
            // If there is a map, then expose a new center of the map and change the data and position of the label in accordance with the found address.
        } else {
            map.setCenter(state.center, state.zoom);
            placemark.geometry.setCoordinates(state.center);
            placemark.properties.set({iconCaption: caption, balloonContent: caption});
        }
    }
}