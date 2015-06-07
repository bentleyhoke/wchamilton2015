// This is a manifest file that'll be compiled into application.js, which will include all the files
// listed below.
//
// Any JavaScript/Coffee file within this directory, lib/assets/javascripts, vendor/assets/javascripts,
// or any plugin's vendor/assets/javascripts directory can be referenced here using a relative path.
//
// It's not advisable to add code directly here, but if you do, it'll appear at the bottom of the
// compiled file.
//
// Read Sprockets README (https://github.com/rails/sprockets#sprockets-directives) for details
// about supported directives.
//
//= require jquery
//= require jquery_ujs
//= require turbolinks
//= require_tree .

$( document ).ready(function() {
	if ($('#lat').length && $('#lng').length) {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(locateSuccess, locateFail);
		}
		function locateSuccess(loc) {
			var latitude = loc.coords.latitude;
			var longitude = loc.coords.longitude;

			//alert('You are at ' + latitude + ', ' + longitude);
			$('#lat').val(latitude);
			$('#lng').val(longitude);
		}
		function locateFail(geoPositionError) {
			switch (geoPositionError.code) {
				case 0: // UNKNOWN_ERROR
					alert('An unknown error occurred, sorry');
					break;
				case 1: // PERMISSION_DENIED
					alert('Permission to use Geolocation was denied');
					break;
				case 2: // POSITION_UNAVAILABLE
					alert('Couldn\'t find you...');
					break;
				case 3: // TIMEOUT
					alert('The Geolocation request took too long and timed out');
					break;
				default:
			}
		}
	}
});