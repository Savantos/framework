<?php

/*
 * TF OPTIONS: opentable
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------
// TODO Add functionality to edit existing slides.

function themeforce_opentable_page() {
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
 
        array( "name" => "opentable Settings", "type" => "title"),

        array( "type" => "open"),   

        array( 
		"name" => "Restaurant ID",
		"desc" => "This is the numeric ID of your restaurant, usually a few numbers, i.e. '12345'",
		"id" => "tf_opentable_id",
		"std" => "",
		"type" => "text"
        ),

        array( 
		"name" => "Enable OpenTable Reservation Bar?",
		"desc" => "This will show the OpenTable bar at the top of your website on every page",
		"id" => "tf_opentable_bar_enabled",
		"std" => "false",
		"type" => "checkbox"
        ),
              
		array( "type" => "close"), 
 
	);
	
	$options = apply_filters( 'tf_options_opentable', $options );

    tf_display_settings( $options );
    ?> 
	 <input type="submit" id="tf-submit" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        <div id="tf-tip">
            <h3>Did you know?</h3>
            <p>Having a opentable profile can increase your exposure to various plenty of new customers. In May 2011, they recorded the following numbers:</p>
            <ul>
                <li>A whopping 27% of all opentable searches come from that iPhone application.</li>
                <li>Over half a million calls were made to local businesses directly from the iPhone App, or one in every five seconds.</li>
                <li>Nearly a million people generated point-to-point directions to a local business from their opentable iPhone App last month.</li>
            </ul>

        </div>    
    </div>
    <?php
        
}	
?>