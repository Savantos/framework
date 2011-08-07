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

function themeforce_social_gowalla_page() {
    ?>
    <div class="wrap" id="tf-options-page">
    <div id="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";
    $options_yesno = array ('yes','no');
    $options_yelp = array('US', 'CA', 'GB', 'IE', 'FR', 'DE', 'AT', 'NL', 'ES');
    
    // Options
    
    $options = array (
 
        array( "name" => "Yelp Settings", "type" => "title"),

        array( "type" => "open"),   

        array( 
		"name" => "Enable Yelp Bar?",
		"desc" => "This will show the Yelp bar above in line with Yelp display requirements. The fields below need to be completed in order for this to work.",
		"id" => "tf_yelp_enabled",
                "std" => "false",
                "type" => "select",
                "class" => "small", //mini, tiny, small
                "options" => $options_yesno),

        array( 
               	"name" => "API Key",
		"desc" => "Required for Yelp Button  <a target='_blank' href='http://www.yelp.com/developers/getting_started/api_overview'>Get it from here (Yelp API)</a>",
		"id" => "tf_yelp_api_key",
                "std" => "",
                "type" => "text"),
        
        array( 
		"name" => "Country",
		"desc" => "Required so that your Phone Number below can be correctly identified",
		"id" => "tf_yelp_country_code",
		"type" => "select",
		"class" => "mini", //mini, tiny, small
		"options" => $options_yelp),
        
        array( 
		"name" => "Phone number registered with Yelp",
		"desc" => "Required for Yelp Button (Used by the API to identify your business). Do not use special characters, only numbers.",
		"id" => "tf_yelp_phone",
                "std" => "",
                "type" => "text"),        
      
	array( "type" => "close"), 
 
);

    tf_display_settings($options);
    ?> 
	 <input type="submit" id="tf-submit" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        <!--
        <div id="tf-tip">
            <h3>Why is Location important?</h3>
            <p>We use location data to enhance content across your website. An example of this are Events: Your location is attached to individual events which means that you can potentially <strong>increase your traffic from Google, Yahoo or Bing</strong> for local event searches.</p>
            <img src="http://1.bp.blogspot.com/_o5Na_9269nA/S1nnV8U-pYI/AAAAAAAADX0/FkIocIhR7Ig/s400/events-rich-snippets.png" />
        </div>    
        -->
    </div>
    <?php
        
}	
?>