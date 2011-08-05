<?php

/*
 * TF OPTIONS: LOGO
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------
// TODO Add functionality to edit existing slides.

function themeforce_logo_page() {
    ?>
    <div class="wrap" id="tf-options-page">
    <div id="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "baseforce";
    $options_yesno = array ('yes','no');
    
    // Options
    
    $options = array (
 
        array( "name" => "Logo", "type" => "title"),

        array( "type" => "open"),   
	
        // LOCATION
	// -----------------------------------------------------------------

	// new 3.2.2					
	 array( "name" => "Logo",
                "desc" => "The street address. For exampl: 1600 Amphitheatre Pkwy",
                "id" => $shortname."_logo",
                "std" => "",
                "type" => "image"),
		
	// new 3.2.2		
	array( "name" => "Favicon",
                "desc" => "The locality. For example, Mountain View, Miami, Sydney, etc.",
                "id" => $shortname."_favicon",
                "std" => "",
                "type" => "image"),					
      
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