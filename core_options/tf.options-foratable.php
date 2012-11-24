<?php

/*
 * TF OPTIONS: ForAtable
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

function themeforce_foratable_page() {
    ?>
    <div class="tf-options-page">
    <div class="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";
    
    // Options
    
    $options = array (

        array( 'type' => 'open'),

        array( 
		'name' => __( 'Restaurant ID', 'themeforce'),
		'desc' => __( 'This is the numeric phone number of your restaurant, with full prefix, i.e. \'0041431234567\'', 'themeforce'),
		'id' => 'tf_foratable_id',
		'std' => '',
		'type' => 'text'
        ),

        array( 
		'name' => __( 'Enable ForAtable Button?', 'themeforce'),
		'desc' => __( 'This will show the ForAtable button at the top of your website on every page', 'themeforce'),
		'id' => 'tf_foratable_enabled',
		'std' => 'false',
		'type' => 'checkbox'
        ),

	array( 'type' => 'close'), 
 
	);
	
	$options = apply_filters( 'tf_options_foratable', $options );

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes', 'themeforce' )  ?>" />
         <div style="clear:both;"></div>
    </form>

    </div>
    </div>
    <?php
        
}	
?>