<?php

function tf_update_site_timezone( $newvalue ) {
		$country = $newvalue;
		$geo_location = get_geolocation_from_address( $country );
		
		if ($geo_location)
			$timezone = get_timezone_from_geolocation($geo_location);
		else
			return $newvalue;
			
		return $newvalue;	
}
add_filter( 'pre_update_option_tf_address_country', 'tf_update_site_timezone' );

function get_geolocation_from_address( $country ) {

		// Grab Addresss Data
    
    	$new_address = get_option('tf_address_street') . ', ' . get_option('tf_address_locality') . ', ' . get_option('tf_address_postalcode') . ' ' . get_option('tf_address_region') . ' ' . $country;
    
    	// Choose
    
   		 if (get_option('tf_address_street') . get_option('tf_address_country') !== '')
   		{
      		$valid_address = $new_address;    
    	} else {
        	$valid_address = get_option('tf_business_address');
    	}

		// clean data
		
		$cleanaddress = urlencode($valid_address);
		
		// geocode

		$geocode = @file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $cleanaddress . '&sensor=false');

		
		if( !$geocode )
			continue;

		$output= json_decode($geocode);

		$location['lat'] = $output->results[0]->geometry->location->lat;
		$location['long'] = $output->results[0]->geometry->location->lng;
		
		return $location;
		


}
function get_timezone_from_geolocation( $location ){

	$timezone = simplexml_load_file('http://www.earthtools.org/timezone/'. $location['lat'] . '/' . $location['long'] );
	
	update_option( 'gmt_offset', $timezone->offset );

}

