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
    
    $shortname = "tf";
    $options_yesno = array ( 'yes', 'no' );
    
    // Options
    
    $options = array (
 
        array( 'name' => 'Logo', 'type' => 'title'),

        array( 'type' => 'open'),   
	
	// new 3.2.2					
	 array( 'name' => 'Logo',
                'desc' => 'Your business logo (choose from an array of formats .JPG, .GIF, .PNG)',
                'id' => $shortname.'_logo_id',
                'std' => '',
                'size' => 'width=300&height=300&crop=0',
                'type' => 'image'),
		
	// new 3.2.2		
   	array( 'name' => 'Favicon',
                'desc' => 'Your Favicon, make sure it is 16px by 16px (you can <a href=\'http://www.favicon.cc/\' target=\'_blank\'>generate one here</a>)',
                'id' => $shortname.'_favicon',
                'std' => '',
                'type' => 'image',
                'allowed_extensions' => array( 'ico' ),
                'drop_text' => 'Drop favicon here'), 					
      
	array( 'type' => 'close'), 
 
);

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
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

function tf_logo( $size ='width=250&height=200&crop=0' ) {
	
	if ( get_option( 'tf_logo_id' ) )
		$logo_id = (int) get_option( 'tf_logo_id' );
	
	else
		$logo_id = null;
	
	if ( $logo_id )
		$logo_src = reset( wp_get_attachment_image_src( $logo_id, $size ) );
	
	elseif ( get_option( 'tf_logo' ) )
		$logo_src = get_option( 'tf_logo' );
	
	else
		$logo_src = get_bloginfo( 'template_directory' ) . '/images/logo.jpg';
	
	$logomobile = wpthumb( $logo_src, 'width=200&height=160&crop=0' ); 
	
	if ( is_user_logged_in() ) :
		
		$uploader = new TF_Upload_Image_Well( 'tf_logo_id', $logo_id, $size );
		$uploader->drop_text = 'Drop your logo here';
	    ?>

	    <div style="float:left;">
	    	<?php $uploader->html() ?>
	    </div>
	
	<?php else : ?>
	
	    <div style="float:left;"><a href="<?php bloginfo('url'); ?>" id="logo"><div id="logo" style="background-image:url(<?php echo $logo_src; ?>)"></div></a></div>
	
	<?php endif; ?>
	    
    <div id="logo-mobile" style="display:none;">
        <a href="<?php bloginfo('url'); ?>"><div style="background:url('<?php echo $logomobile; ?>') no-repeat center center"></div></a>
    </div>
	
	<?php

}

//include the image picker JS etc
add_action( 'wp_head', function() {
	if ( is_user_logged_in() )
		TF_Upload_Image_Well::enqueue_scripts();
}, 1 );