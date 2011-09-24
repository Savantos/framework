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

function themeforce_social_foursquare_page() {
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
 
        array( "name" => "Foursquare Settings", "type" => "title"),

        array( "type" => "open"),   

        array( 
  		"name" => "Venue ID",
		"desc" => "If your profile URL is http://foursquare.com/venue/12345, then your Venue ID is 12345",
		"id" => "tf_fsquare_venue_id",
                "std" => "",
                "type" => "text"),   
        
        array( 
               	"name" => "Client ID",
		"desc" => "Request API access here, register <a href='https://foursquare.com/oauth/' target='_blank'>here</a>. Callback URL does not matter for the Venues APIv2 we'll be using.",
		"id" => "tf_fsquare_client_id",
                "std" => "",
                "type" => "text"),        
        
        array( 
		"name" => "Client Secret",
		"desc" => "Provided together with the Client ID above.",
		"id" => "tf_fsquare_client_secret",
                "std" => "",
                "type" => "text"),        
      
	array( "type" => "close"), 
 
);

    tf_display_settings( $options );
    ?> 
	 <input type="submit" id="tf-submit" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        <div id="tf-tip">
            <h3>How can I get more out of Foursquare?</h3>
            <p>If you're looking to increase check-ins, try creating special gifts for Mayors (the people who check in the most) as well as other special offers through Foursquare.</p>
        </div>    
    </div>
    <?php
        
}	
?>