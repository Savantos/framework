<?php

/*
 * TF OPTIONS: MAILCHIMP
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------
// TODO Add functionality to edit existing slides.

function themeforce_mailchimp_page() {
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
 
        array( 'name' => 'MailChimp Settings', 'type' => 'title'),

        array( 'type' => 'open'),   

        array( 
		'name' => 'API Key',
		'desc' => 'If you\'re unsure where to find your API key, please <a href=\'http://kb.mailchimp.com/article/where-can-i-find-my-api-key/\' target=\'_blank\'>click here</a>.',
		'id' => 'tf_mailchimp_api_key',
		'std' => '',
		'type' => 'text'
	),
      
	array( 'type' => 'close'), 
 
);

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        <div id="tf-tip">
            <h3>Why is a MailChimp Newsletter important?</h3>
            <p>A newsletter allows you to <strong>automatically</strong> keep in touch with your customer base, updating them on the latest news & events. You can set your newsletter to automatically send off your events on a weekly or monthly basis.</p>
        </div>    
    </div>
    <?php
        
}	
?>