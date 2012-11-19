<?php

/*
 * TF OPTIONS: LOGO
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------

function themeforce_logo_page() {
	
	// migrate tf_logo to tf_logo_id

	if ( ! get_option( 'tf_logo_id' ) && get_option( 'tf_logo' ) ) {
	
		$logo = hm_remote_get_file( get_option( 'tf_logo' ) );
		$info = getimagesize( $logo );
		$post_id = wp_insert_attachment( array( 'post_mime_type' => $info['mime'] ), $logo );
		
		$meta = wp_generate_attachment_metadata( $post_id, $logo );
		wp_update_attachment_metadata( $post_id, $meta );

		if ( $post_id ) {
			update_option( 'tf_logo_id', $post_id );
			delete_option( 'tf_logo' );
		}
			
	}
	
    ?>
    <div class="wrap" id="tf-options-page">
    <div id="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 

    // Options
    
    $options = array (
 
        array( 'name' => __('Logo', 'themeforce'), 'type' => 'title'),

        array( 'type' => 'open'),

	    array( 'name' => __('Logo', 'themeforce'),
                    'desc' => __('Your business logo (choose from an array of formats .JPG, .GIF, .PNG)', 'themeforce'),
                    'id' => 'tf_logo_id',
                    'std' => '',
                    'size' => 'width=300&height=300&crop=0',
                    'type' => 'image'),

        array( 'name' => __( 'Text Logo', 'themeforce' ),
                'desc' => __( 'Don\'t have an image logo yet? Choose some text to appear in the logo area instead.' ),
                'id' => 'blogname',
                'std' => '',
                'type' => 'text'),

   	    array( 'name' => __('Favicon', 'themeforce'),
                    'desc' => __('Your Favicon, make sure it is 16px by 16px (you can <a href=\'http://www.favicon.cc/\' target=\'_blank\'>generate one here</a>)', 'themeforce'),
                    'id' => 'tf_favicon',
                    'std' => '',
                    'type' => 'image',
                    'allowed_extensions' => array( 'ico' ),
                    'drop_text' => __('Drop favicon here', 'themeforce')),

	    array( 'type' => 'close'),
 
    );

    if ( ! get_current_theme() == 'Baseforce' )
        unset( $options[3] );

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes','themeforce' )  ?>" />
         <div style="clear:both;"></div>
    </form>

    </div>
    <?php
        
}	

function tf_logo( $size ='width=250&height=200&crop=0' ) {
	
	$logo_src = tf_logo_url( $size );

	$logomobile = wpthumb( $logo_src, 'width=200&height=160&crop=0' );

    $uploader = new TF_Upload_Image_Well( 'tf_logo_id', get_option( 'tf_logo_id', 0 ), array( 'size' => $size ) );
    $uploader->drop_text = __('Drop your logo here', 'themeforce');

    $use_image_logo = ( ( get_option( 'tf_image_logo_selected' ) && ! get_option( 'tf_text_logo_selected' ) ) || ( ! get_option( 'tf_text_logo_selected' ) && $logo_src ) ) ? true : false;

    switch( get_current_theme() ) :

        case 'Baseforce':

            if ( is_user_logged_in() ) : ?>
                <div class="logo-image-well logo_container" style="float:left; <?php echo ( ! $use_image_logo ) ? 'display: none;' : ''; ?>">
                    <?php $uploader->html() ?>
                </div>

                <a id="nologo-wrap" class="logo_container" style="<?php echo ( $use_image_logo ) ? 'display: none;' : ''; ?>" href="<?php echo home_url(); ?>"><div class="nologo"><?php echo tf_get_logo_text(); ?></div><input type="button" class="frontend tf_switch_logo_type" value="Switch to Image" /></a>

            <?php else : ?>

                <?php if ( $use_image_logo ): ?>
                    <div style=""><a href="<?php bloginfo('url'); ?>"><div id="logo" style="background-image:url(<?php echo $logo_src; ?>)"></div></a></div>
                    <?php else: ?>
                    <a id="nologo-wrap" href="<?php echo home_url(); ?>"><div class="nologo"><?php echo tf_get_logo_text(); ?></div></a>
                    <?php endif; ?>

            <?php endif; ?>

            <?php if ( $use_image_logo ) : ?>
                <div id="logo-mobile" style="display:none;">
                    <a href="<?php bloginfo('url'); ?>"><div style="background:url('<?php echo $logomobile; ?>') no-repeat center center"></div></a>
                </div>
            <?php else: ?>
                <div id="logo-mobile" class="no-logo" style="display:none;">
                    <a id="nologo-wrap-mobile" href="<?php echo home_url(); ?>"><div class="nologo"><?php echo tf_get_logo_text(); ?></div></a>
                </div>
            <?php endif;

            break;

        default:

            if ( is_user_logged_in() ) : ?>
                <div class="logo-image-well" style="float:left;">
                    <?php $uploader->html() ?>
                </div>

            <?php else : ?>
                <div style=""><a href="<?php bloginfo('url'); ?>"><div id="logo" style="background-image:url(<?php echo $logo_src; ?>)"></div></a></div>
            <?php endif; ?>

            <div id="logo-mobile" style="display:none;">
                <a href="<?php bloginfo('url'); ?>"><div style="background:url('<?php echo $logomobile; ?>') no-repeat center center"></div></a>
            </div>

            <?php break;

    endswitch;

}

function tf_logo_url( $size ='width=250&height=200&crop=0' ) {
	
	if ( get_option( 'tf_logo_id' ) )
		$logo_id = (int) get_option( 'tf_logo_id' );
	
	else
		$logo_id = null;
	
	if ( $logo_id )
		$logo_src = reset( wp_get_attachment_image_src( $logo_id, $size ) );
	
	elseif ( get_option( 'tf_logo' ) )

		$logo_src = wpthumb( get_option( 'tf_logo' ), $size );
	
	else
		$logo_src = '';

    // This is defaulting to a logo when we probably want to keep it empty
	// $logo_src = wpthumb( get_bloginfo( 'template_directory' ) . '/images/logo.jpg', $size );
	
	return $logo_src;
}

function tf_get_favicon_url() {

	if ( is_numeric( $logo_id = get_option( 'tf_favicon' ) ) )
		$logo_src = wp_get_attachment_image_src( $logo_id, 'width=16&height=16' ) ? reset( wp_get_attachment_image_src( $logo_id, 'width=16&height=16' ) ) : '';
	
	elseif ( get_option( 'tf_favicon' ) )
		$logo_src = get_option( 'tf_favicon' );
	
	elseif ( get_option( 'tf_custom_favicon' ) )
		$logo_src = get_option( 'tf_custom_favicon' );

	return $logo_src;
}

//include the image picker JS etc
add_action( 'wp_head', function() {
	if ( is_user_logged_in() )
		TF_Upload_Image_Well::enqueue_scripts();
}, 1 );

function tf_get_logo_text() {

    if ( get_option( 'tf_logo_text' ) )
        return get_option( 'tf_logo_text' );

    return get_option( 'tf_business_name' );
}


add_action( 'wp_ajax_tf_switch_logo_display_type', function() {

    if ( ! get_current_user_id() || empty( $_POST['action'] ) || $_POST['action'] != 'tf_switch_logo_display_type' )
        exit;

    $switch_to = (string) $_POST['switch_to'];

    if ( $switch_to == 'text' ) {
        update_option( 'tf_image_logo_selected', false );
        update_option( 'tf_text_logo_selected', true );

    } elseif ( $switch_to == 'image' ) {
        update_option( 'tf_image_logo_selected', true );
        update_option( 'tf_text_logo_selected', false );
    }

    exit;

} );