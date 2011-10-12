<?php

// Function to use for all calls

function tf_facebook_get_og($page, $path) {
    $access_token = 'AAACEdEose0cBAKKMUoQ8fyWyZC5uCp5VQNTTQNFO41HkMjGc0H3B1VcrvsYL5AQ1APimaOoiOOEZBQO1HvZCW4XVEqyM8cZD';
    if ( $path ) { $seperator = '/';}
    $url = 'https://graph.facebook.com/' . $page . $seperator . $path .'?access_token=' . $access_token;
    $api = wp_remote_get( $url , array('sslverify' => false) );
    return json_decode( wp_remote_retrieve_body( $api ) );    
}

// Function to display Facebook Events

function tf_events_facebook ( $atts ) {
	
	// - define arguments -
	extract(shortcode_atts(array(
	    'limit' => '30', // # of events to show
	 ), $atts ));
	
	// ===== OUTPUT FUNCTION =====
	
	ob_start();
	
	// ===== LOOP: FULL EVENTS SECTION =====
	
	// - make sure it's a number for our query -
	
	$limit = intval( $limit );
        
        // - declare fresh day -
	$daycheck = null;
	
	echo '<!-- www.schema.org -->';

        // Run through events

        $event_list = tf_facebook_get_og( 'themeforce' , 'events' );
        
        foreach ( $event_list->data as $event_short ):

                $event_id = $event_short->id;
                echo $event_id;
                // OG : Parent Data
                //------------------

                $event_parent = tf_facebook_get_og($event_id,'');
                
                // Check for Event Privacy
                
                if ( $event_parent->privacy == 'OPEN' ) {

                        $event_url = 'https://www.facebook.com/event.php?eid=' . $event_id;

                        // returns: strings  
                        $event_name = $event_parent->name;
                        $event_desc = $event_parent->description;
                        $event_location = $event_parent->location;

                        // returns: date formatted according to WP    
                        $event_start_date = mysql2date(get_option( 'date_format' ), $event_parent->start_time );
                        $event_start_time = mysql2date( get_option( 'time_format' ), $event_parent->start_time );
                        $event_end_time = mysql2date( get_option( 'time_format' ), $event_parent->end_time );

                        // OG : Attending
                        //------------------

                        $attending = tf_facebook_get_og($event_id,'attending');

                        // returns: int
                        $event_attending = count($attending->data);
                                                
                        // Date check

                        if ($daycheck == null) { echo '<h2 class="full-events">' . $event_start_date . '</h2>'; }
                        if ($daycheck != $event_start_date && $daycheck != null) { echo '<h2 class="full-events">' . $event_start_date . '</h2>'; }
                        
                        ?>
                        
                       	<div itemprop="events" itemscope itemtype="http://schema.org/Event">
                        <div class="full-events">
                            <div class="text">
                                <div class="title">
                                        <!-- date --> <div class="time"><span itemprop="startDate" content="<?php echo $event_start_date; ?>"><?php echo $stime . ' - ' . $etime; ?></span></div>
                                        <!-- duration --> <meta itemprop="duration" content="PT<?php echo $schema_duration; ?>M" />
                                        <!-- url & name --> <div class="eventtext"><a itemprop="url" href="<?php echo $$event_url; ?>"><div itemprop="name"><?php echo $event_name; ?></div></a></div>
                                        <!-- location --> <meta itemprop="location" content="<?php echo $location;?>" />
                                </div>
                            </div>
                            <!-- description --><div class="desc" itemprop="description"><?php the_content() ?></div>
                        </div>
                        </div>
	
                        <!-- www.schema.org -->   
                        
                        <?php
                
                }
      
                $daycheck = $event_start_date;

        endforeach;
            
        $output = ob_get_contents();
	ob_end_clean();
	return $output;
}

add_shortcode('tf-events-facebook', 'tf_events_facebook');

?>