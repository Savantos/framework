<?php

/*
 * TF OPTIONS: YELP
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------
// TODO Add functionality to edit existing slides.

function themeforce_social_yelp_page() {
    ?>
    <div class="wrap" id="tf-options-page">
    <div id="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";
    $options_yesno = array ( 'yes', 'no' );
    $options_yelp = array('US', 'CA', 'GB', 'IE', 'FR', 'DE', 'AT', 'NL', 'ES');
    
    // Options
    
    $options = array (
 
        array( 'name' => 'Yelp Settings', 'type' => 'title'),

        array( 'type' => 'open'),   

        array( 
			'name' => 'Enable Yelp Bar?',
			'desc' => 'This will show the Yelp bar above in line with Yelp display requirements. The fields below need to be completed in order for this to work.',
			'id' => 'tf_yelp_enabled',
            'std' => 'false',
            'type' => 'checkbox',
            'class' => 'small', //mini, tiny, small
        ),

        array( 
        	'name' => 'API Key',
			'desc' => 'Required for Yelp Button  <a target=\'_blank\' href=\'http://www.yelp.com/developers/getting_started/api_overview\'>Get it from here (Yelp API)</a>',
			'id' => 'tf_yelp_api_key',
			'std' => '',
            'type' => 'text'
        ),
        
        array( 
			'name' => 'Country',
			'desc' => 'Required so that your Phone Number below can be correctly identified',
			'id' => 'tf_yelp_country_code',
			'type' => 'select',
			'class' => 'mini', //mini, tiny, small
			'options' => $options_yelp
		),
        
        array( 
			'name' => 'Phone number registered with Yelp',
			'desc' => 'Required for Yelp Button (Used by the API to identify your business). Do not use special characters, only numbers.',
			'id' => 'tf_yelp_phone',
            'std' => '',
            'type' => 'text'
		), 
      
		array( 'type' => 'close'), 
 
	);
	
	$options = apply_filters( 'tf_options_yelp', $options );

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        <div id="tf-tip">
            <h3>Did you know?</h3>
            <p>Having a Yelp profile can increase your exposure to various plenty of new customers. In May 2011, they recorded the following numbers:</p>
            <ul>
                <li>A whopping 27% of all Yelp searches come from that iPhone application.</li>
                <li>Over half a million calls were made to local businesses directly from the iPhone App, or one in every five seconds.</li>
                <li>Nearly a million people generated point-to-point directions to a local business from their Yelp iPhone App last month.</li>
            </ul>

        </div>    
    </div>
    <?php
        
}	
?>