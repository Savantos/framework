<?php

/*
 * TF OPTIONS: FULL BACKGROUND
 * 
 */

function themeforce_theme_options() {
    add_submenu_page('themes.php', 'Full Background', 'Full Background', 'manage_options', 'themeforce_theme_options', 'themeforce_themeoptions_page');
}
add_action('admin_menu','themeforce_theme_options');



function themeforce_themeoptions_page() {
    ?>
    <div class="wrap" id="tf-options-page">
    <div id="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
        
    <?php 
   
    
    // Options
    
    $options = array (
 
        array( 'name' => 'Enable', 'type' => 'title'),

        array( 'type' => 'open'),   
	
        array( 'name' => 'Use Full-Screen Background?',
                'desc' => 'Check this box if you\'d like to use a full background image that resizes with the browser.',
                'id' => 'tf_full_background',
                'std' => 'true',
                'type' => 'checkbox'),
	
        array( 'name' => 'Background Image',
                'desc' => 'Your background image (we recommend using a JPG that is smaller than 300kb in size, yet around 1400px in width)',
                'id' => 'tf_background',
                'std' => '',
                'type' => 'image'),
	
	array( 'type' => 'close'), 
 
);

    tf_display_settings($options);
    ?>         
	 <input type="submit" id="tf-submit" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        <div id="tf-tip">
            <h3>Create Depth</h3>
            <p>We recommend using an image that has perspective (i.e. foreground & background) to create depth visually within your website.</p>
        </div>    
    </div>
    <?php   
}	
?>