<?php

/*
 * TF OPTIONS: Localina
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------

function themeforce_localina_page() {
    ?>
    <div class="wrap" id="tf-options-page">
    <div id="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";
    $options_yesno = array ( 'yes', 'no' );
    
    // Options
    
    $options = array (
 
        array( 'name' => 'Localina Settings', 'type' => 'title'),

        array( 'type' => 'open'),

        array(
        'name' => 'Restaurant API Key',
        'desc' => 'This is your personal API key',
        'id' => 'tf_localina_api',
        'std' => '',
        'type' => 'text'
        ),

        array( 
		'name' => 'Restaurant Phone Number',
		'desc' => 'This is the numeric phone number of your restaurant, with full prefix, i.e. \'0041431234567\'',
		'id' => 'tf_localina_phone',
		'std' => '',
		'type' => 'text'
        ),

        array( 
		'name' => 'Enable Localina Reservation Bar?',
		'desc' => 'This will show the Localina bar at the top of your website on every page',
		'id' => 'tf_localina_bar_enabled',
		'std' => 'false',
		'type' => 'checkbox'
        ),

        array(
        'name' => 'Reservation Bar Text',
        'desc' => 'Text used for the link',
        'id' => 'tf_localina_bar_text',
        'std' => 'Reserve a table online',
        'type' => 'text'
        ),
              
	array( 'type' => 'close'), 
 
	);
	
	$options = apply_filters( 'tf_options_localina', $options );

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>

    </div>
    <?php
        
}	
?>