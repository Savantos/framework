<?php

// Function to use for all calls

function tf_facebook_get_og($page, $path) {
    $access_token = 'AAACEdEose0cBAKKMUoQ8fyWyZC5uCp5VQNTTQNFO41HkMjGc0H3B1VcrvsYL5AQ1APimaOoiOOEZBQO1HvZCW4XVEqyM8cZD';
    if ( $path ) { $seperator = '/';}
    $url = 'https://graph.facebook.com/' . $page . $seperator . $path .'?access_token=' . $access_token;
    $api = wp_remote_get( $url , array('sslverify' => false) );
    return json_decode( wp_remote_retrieve_body( $api ) );    
}

// Run through events

$event_list = tf_facebook_get_og('themeforce', 'events');

foreach ( $event_list->data as $event_short ) {
	
    	$event_id = $event_short->id;
        
        // OG : Parent Data
        //------------------
        
        $event_parent = tf_facebook_get_og($event_id,'');
		
	// Check for Event Privacy

	if ( $event_parent->privacy == 'OPEN' ) {
            
                $event_url = 'https://www.facebook.com/event.php?eid=' . $event_id;
	
                // returns: strings  
                $event_name = $event_parent->name;
		$event_desc = $event_parent->description;

                // returns: date formatted according to WP    
		$event_start_date = mysql2date(get_option( 'date_format' ), $event_parent->start_time );
		$event_start_time = mysql2date( get_option( 'time_format' ), $event_parent->start_time );
		$event_end_time = mysql2date( get_option( 'time_format' ), $event_parent->end_time );

	
			// OG : Attending
                        //------------------
			
			$attending = tf_facebook_get_og($event_id,'attending');
			
                        // returns: int
			$event_attending = count($attending->data);
			
			// OG : Picture
                        //------------------
			/*
			$picture = tf_facebook_get_og($event_id,'picture');
                        print_r($picture);
			*/
	
	}
}
?>