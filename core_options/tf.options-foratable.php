<?php

/*
 * TF OPTIONS: forAtable
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
    
    if ( get_option( 'lunchgate_restaurant_id' ) ) {
        $id = get_option( 'lunchgate_restaurant_id' );
    } else {
        $id = '';
    }
    
    // Options
    
    $options = array (

        array( 'type' => 'open'),

        array( 
		'name' => __( 'Lunchgate ID', 'themeforce'),
		'desc' => __( 'This is your Lunchgate ID, i.e. \'170\'', 'themeforce'),
		'id' => 'tf_foratable_id',
		'std' => $id,
		'type' => 'text'
        ),

        array( 
		'name' => __( 'Enable forAtable Button?', 'themeforce'),
		'desc' => __( 'This will show the forAtable button at the top of your website on every page', 'themeforce'),
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