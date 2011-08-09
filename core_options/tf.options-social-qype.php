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

function themeforce_social_qype_page() {
    ?>
    <div class="wrap" id="tf-options-page">
    <div id="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";
    $options_yesno = array ('yes','no');
    
    // Options
    
    $options = array (
 
        array( "name" => "Qype Settings", "type" => "title"),

        array( "type" => "open"),   

	array( 
		"name" => "Enable Qype Bar?",
		"desc" => "This will show the qype bar above in line with qype display requirements. The fields below need to be completed in order for this to work.",
		"id" => "tf_qype_enabled",
		"std" => "false",
		"type" => "checkbox"
	),
	
	array( 
		"name" => "API Key",
		"desc" => "Required for Qype Button  <a target='_blank' href='http://www.qype.com/developers/getting_started/api_overview'>Get it from here (qype API)</a>",
		"id" => "tf_qype_api_key",
		"std" => "",
		"type" => "text"
	),
	
	 array( 
		"name" => "Qype Place ID",
		"desc" => "Used by the API to identify your business, they are the x's in your link http://www.qype.co.uk/place/<strong>xxxxx</strong>-name-of-your-business",
		"id" => "tf_qype_place",
		"std" => "",
		"type" => "text"
	),
       
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