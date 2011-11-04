<?php

/*
 * TF OPTIONS: LOCATION
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */


// Create Page
// -----------------------------------------
// TODO Add functionality to edit existing slides.

function themeforce_location_page() {
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
 
        array( 'name' => 'Location Details', 'type' => 'title'),

        array( 'type' => 'open'),   
	
        // LOCATION
	// -----------------------------------------------------------------

	// new 3.2.2					
	 array( 'name' => 'Street Name',
                'desc' => 'The street address. For exampl: 1600 Amphitheatre Pkwy',
                'id' => $shortname.'_address_street',
                'std' => '',
                'type' => 'text'),
		
	// new 3.2.2		
	array( 'name' => 'Town or Locality',
                'desc' => 'The locality. For example, Mountain View, Miami, Sydney, etc.',
                'id' => $shortname.'_address_locality',
                'std' => '',
                'type' => 'text'), 					
	
	// new 3.2.2		
	array( 'name' => 'State or Region',
                'desc' => 'The region. For example, CA.',
                'id' => $shortname.'_address_region',
                'std' => '',
                'type' => 'text'), 		

	// new 3.2.2		
	array( 'name' => 'Country',
                'desc' => 'Select your country',
                'id' => $shortname.'_address_country',
                'std' => '',
                'type' => 'text'), 	
						
	array( 'name' => 'Phone Number',
                'desc' => 'Your business phone number.',
                'id' => $shortname.'_business_phone',
                'std' => '( 123 ) 456 789',
                'type' => 'text'),
							

	array( 'name' => 'Short Contact Info',
                'desc' => 'Visible contact information in the top-right corner (you can also leave blank)',
                'id' => 'chowforce_biz_contactinfo',
                'std' => 'Call us at +01 ( 02 ) 123 57 89',
                'type' => 'text'), 				

	array( 'type' => 'close'), 
 
);

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        
        <div id="tf-tip">
            <h3>Why is Location important?</h3>
            <p>We use location data to enhance content across your website. An example of this are Events: Your location is attached to individual events which means that you can potentially <strong>increase your traffic from Google, Yahoo or Bing</strong> for local event searches.</p>
        </div>    
        
    </div>
    <?php
        
}	
?>