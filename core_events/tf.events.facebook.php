<?php

// Function to use for all calls

function tf_facebook_get_og($page, $path) {
    // $access_token = get_option( 'tf_facebook_access_token' );
    $access_token = 'AAACEdEose0cBAKKMUoQ8fyWyZC5uCp5VQNTTQNFO41HkMjGc0H3B1VcrvsYL5AQ1APimaOoiOOEZBQO1HvZCW4XVEqyM8cZD';
    if ( $path ) { $seperator = '/';}
    $url = 'https://graph.facebook.com/' . $page . $seperator . $path .'?access_token=' . $access_token;
    $api = wp_remote_get( $url , array('sslverify' => false) );
    return json_decode( wp_remote_retrieve_body( $api ) );    
}

// Function to display Facebook Events

function tf_events_facebook ( $limit ) {
	
	// ===== OUTPUT FUNCTION =====
	
	ob_start();
	
	// ===== LOOP: FULL EVENTS SECTION =====
	
	// - make sure it's a number for our query -
	
	$limit = intval( $limit );
        
        // - grab business -
        
        $fbpage = 'innisfreebham';
        
        // - declare fresh values-
        
	$daycheck = null;
        $counter = 0;
	
	echo '<!-- www.schema.org -->';

        // Run through events

        $event_list = tf_facebook_get_og( $fbpage , 'events' );     
        
        foreach ( $event_list->data as $event_short ):

                $event_id = $event_short->id;
        
                // OG : Parent Data
                //------------------
        
                if ( strtotime($event_short->start_time) > strtotime('yesterday') ) {    
        
                $event_parent = tf_facebook_get_og($event_id,'');
                           
                // Check for Event Privacy
                
                    if ( $event_parent->privacy == 'OPEN' ) {
                        
                            $counter++;

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
                                        <!-- date --> <div class="time"><span itemprop="startDate" content="<?php echo $event_start_date; ?>"><?php echo $event_start_time . ' - ' . $event_end_time; ?></span></div>
                                            <!-- duration --> <meta itemprop="duration" content="PT<?php echo $schema_duration; ?>M" />
                                            <!-- url & name --> <div class="eventtext"><a itemprop="url" href="<?php echo $event_url; ?>"><div itemprop="name"><?php echo $event_name; ?></div></a></div>
                                            <!-- location --> <meta itemprop="location" content="<?php echo $event_location;?>" />

                                    </div>
                                </div>
                                <!-- description --><div class="desc" itemprop="description"><strong><a itemprop="url" href="<?php echo $event_url; ?>"><?php echo $event_attending . __(' people are attending','themeforce');?></a></strong><?php echo ' - ' . $event_desc; ?></div>
                            </div>
                            </div>

                            <!-- www.schema.org -->   

                            <?php

                    }

                }    
                    
                $daycheck = $event_start_date;

        endforeach;
            
        if ( $counter < 1 ) { __('We\'re sorry, there are currently no events in Facebook', 'themeforce'); }                    
        
        $output = ob_get_contents();
	ob_end_clean();
	return $output;
}

/**
 * Store API Data
 * 
 */

function tf_events_facebook_transient( $atts ) {

    // - define arguments -
    extract(shortcode_atts(array(
        'limit' => '30', // # of events to show
     ), $atts ));
    
    $limit = intval( $limit );

    // - get transient -
    $events = get_transient( 'tf_events_facebook_transient_data' );

    // - refresh transient -
    if ( !$events ) {
        $events = tf_events_facebook($limit);
        set_transient('tf_events_facebook_transient_data', $events, 1);
	}

    // - data -
    return $events;
}

add_shortcode('tf-events-facebook', 'tf_events_facebook_transient');


/**
 * Registers the Insert Shortcode tinymce plugin for Food menu.
 * 
 */
function tf_fb_events_register_tinymce_buttons() {
	
	if ( !current_user_can( 'edit_posts' ) || 
		( isset( $_GET['post'] ) && !in_array( get_post_type( $_GET['post'] ), array( 'post', 'page' ) ) ) || 
		( isset( $_GET['post_type'] ) && !in_array( $_GET['post_type'], array( 'post', 'page' ) ) ) )
		return;
	
	add_filter( 'mce_external_plugins', 'tf_fb_events_add_tinymce_plugins' );
}
add_action( 'load-post.php', 'tf_fb_events_register_tinymce_buttons' );
add_action( 'load-post-new.php', 'tf_fb_events_register_tinymce_buttons' );

/**
 * Adds the Insert Shortcode tinyMCE plugin for the food menu.
 * 
 * @param array $plugin_array
 * @return array
 */
function tf_fb_events_add_tinymce_plugins( $plugin_array ) {
	$plugin_array['tf_fb_events_shortcode_plugin'] = TF_URL . '/core_events/tinymce_plugins/insert_fb_events_shortcode.js';
	
	return $plugin_array;
}

function tf_fb_events_add_insert_events_above_editor() {
	?>
	<a class="tf-button tf-tiny" href="javascript:tinyMCE.activeEditor.execCommand( 'mceExecTFEventsInsertShortcode' ); return false;"><img src="<?php echo TF_URL . '/core_events/tinymce_plugins/event_16.png' ?>"/><span>Facebook Events</span></a>
	<?php
}
add_action( 'tf_above_editor_insert_items', 'tf_fb_events_add_insert_events_above_editor' );
?>