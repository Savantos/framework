<?php

/*
 * TF OPTIONS: TWITTER
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------
// TODO Add functionality to edit existing slides.

function themeforce_social_twitter_page() {
    ?>
    <div class="wrap tf-options-page">
    <div class="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";
    
    // Options
    
    $options = array (
 
        array( 'name' => 'Twitter Settings', 'type' => 'title'),

        array( 'type' => 'open'),   

	array( 'name' => 'Twitter Link',
                'desc' => 'The link to your Twitter profile/username.',
                'id' => $shortname.'_twitter',
                'std' => '',
                'type' => 'text'),     
      
	array( 'type' => 'close'), 
 
);

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        <!--
        <div id="tf-tip">
            <h3>Did you know?</h3>
            <p>Having a Yelp profile can increase your exposure to various plenty of new customers. In May 2011, they recorded the following numbers:</p>
            <ul>
                <li>A whopping 27% of all Yelp searches come from that iPhone application.</li>
                <li>Over half a million calls were made to local businesses directly from the iPhone App, or one in every five seconds.</li>
                <li>Nearly a million people generated point-to-point directions to a local business from their Yelp iPhone App last month.</li>
            </ul>

        </div>
        -->
    </div>
    <?php
        
}



/*
 * Hooks into update_option to sanitize the twiiter url
 * 
 * @param string value of option
 * @return string - modified value
 */
function tf_escape_site_to_twitter ( $newvalue ){
	
	if (!$newvalue)
		return;

	if( strpos ( $newvalue, 'twitter.'  ) !== false ) {
		$newvalue = esc_url( $newvalue );

	} else {
		$newvalue = ltrim( $newvalue, '@');
		$newvalue = 'http://twitter.com/' . $newvalue;
	}
		
	return $newvalue;		
}
add_filter ( 'pre_update_option_tf_twitter', 'tf_escape_site_to_twitter', 1 );
