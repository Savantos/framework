<?php

/**
 * Enqueue the necissary scripts for the much improved Food Menu quick edit
 * 
 */
function tf_events_enqueue_scripts() {

	if ( empty( $_GET['post_type'] ) || $_GET['post_type'] !== 'tf_events' )
		return;
		
	add_thickbox();
	
	wp_enqueue_script( 'media-uploader-extensions', TF_URL . '/assets/js/media-uploader.extensions.js', array(), TF_VERSION  );
	wp_enqueue_script( 'jquery-ui-sortable' );
	
	_tf_tj_register_custom_media_button( '_tf_events_image', 'Add Image' );
}
add_action( 'load-edit.php', 'tf_events_enqueue_scripts' );

/**
 * Adds the extra fields to the quick edit row on Manage Events.
 * 
 * @param string $column_name
 * @param string $post_type
 * @return void
 */
function tf_events_add_fields_to_quick_edit( $column_name, $post_type ) {

	if ( $post_type !== 'tf_events' )
		return $column_name;
	
	add_action( 'admin_footer', 'tf_events_add_inline_js_to_footer' );
	?>
	
	<?php if ( $column_name == 'tf_col_ev_cat' ): ?>
		
		<div class="tf-quickedit-header">
			<div class="width-item"><h3>Item</h3></div>
			<div class="width-cat"><h3>Event Categories</h3></div>
			<div class="width-image"><h3>Image</h3></div>
			<div class="width-desc"><h3>Description</h3></div>
		</div>
		
		<div id="tf-inline-edit-dates" style="margin-top: 10px">
                    
                    <!-- Old Code -->  
                    
                        
			<span class="title" style="float:left;">Start Date</span>
			<div class="start-date" style="display:block; margin-left: 5em; "></div>
			
			<span class="title" style="float:left;">End Date</span>
			<div class="end-date" style="display:block; margin-left: 5em; padding-top:5px;"></div>
                        
                        
                      <!-- New Code -->  
                        <!--
                        <ul>
                            <li><label>Start Date</label><input name="tf_events_startdate" class="tfdate" value="<?php echo $clean_sd; ?>" /></li>
                            <li><label>Start Time</label><input name="tf_events_starttime" value="<?php echo $clean_st; ?>" /><em><?php _e('Use 24h format (7pm = 19:00)', 'themeforce'); ?></em></li>
                            <li><label>End Date</label><input name="tf_events_enddate" class="tfdate" value="<?php echo $clean_ed; ?>" /></li>
                            <li><label>End Time</label><input name="tf_events_endtime" value="<?php echo $clean_et; ?>" /><em><?php _e('Use 24h format (7pm = 19:00)', 'themeforce'); ?></em></li>
                        </ul>
                        -->
		</div>
		
		<div id="tf-inline-edit-image" style="width:28%; float:left; padding:2% 0">
			<?php _tf_tj_add_image_html_custom( '_tf_events_image', 'Add Image', 0, array(), '', 'width=80&height=80&crop=1', '' ) ?>
		</div>
		
		<div id="tf-inline-edit-description" style="width:66%; padding:2%; float:left;">
			<textarea style="width:100%; height:100px;"></textarea>
			<input type="hidden" name="tf_description" value="" />
		</div>
	<?php endif; ?>
	<?php
	return $column_name;
}
add_action( 'quick_edit_custom_box', 'tf_events_add_fields_to_quick_edit', 10, 2 );

/**
 * Extra JavaScript needed for the food menu quick edit.
 * 
 */
function tf_events_add_inline_js_to_footer() {
	?>
	<script type="text/javascript">
	    jQuery( document ).ready( function() {
	    	
	    	var TFInlineAddedElements = [];
	    	
	    	jQuery( '.row-actions .edit' ).css( 'display', 'none' );
	    	jQuery( '.row-actions .editinline' ).text( '<?php _e( 'Edit' ); ?>' );
	    	jQuery( '.row-title' ).addClass( 'editinline' );
	    	
	    	//hide unwanted stuff
	    	jQuery( '#inlineedit input[name=post_name]' ).closest( 'label' ).hide();
	    	jQuery( '#inlineedit .inline-edit-date' ).hide().prev().filter( function(i, obj) { return jQuery( obj).text() == 'Date'; } ).hide();
	    	jQuery( "#inlineedit input[name=post_password]").closest( 'div.inline-edit-group' ).hide().prev('br').hide();
	    	jQuery( '#inlineedit .inline-edit-tags' ).hide();
			jQuery( "#inlineedit .inline-edit-status").hide();
			jQuery( "#inlineedit .inline-edit-col h4" ).hide();
			jQuery( "#inlineedit .inline-edit-categories-label .catshow" ).click().parent().hide();
			
			jQuery( '#inlineedit' ).addClass( 'tf-menu' );
			jQuery( "#inlineedit .inline-edit-col-left" ).addClass( "width-item" );
			jQuery( "#inlineedit .inline-edit-col-center" ).addClass( "width-cat" );
			jQuery( "#inlineedit .tf-inline-edit-image" ).addClass( "width-image" );
			jQuery( "#inlineedit .tf-inline-edit-description" ).addClass( "width-desc" );
			
			jQuery( "#inlineedit .colspanchange" ).wrapInner( '<div class="tf-quickedit-content"></div>' );
			
			//move stuff around
	    	jQuery( '#inlineedit .inline-edit-date' ).closest( '.inline-edit-col').append( jQuery( '#tf-inline-edit-dates' ) );
	    	
	    	jQuery( '.tf-quickedit-header' ).prependTo( jQuery( '.tf-quickedit-header' ).closest( 'td' ) );
	    	
	    	jQuery( "#tf-inline-edit-add-new-size").live( 'click', function(e) {
	    		e.preventDefault();
				
				if ( jQuery( this ).closest( '#tf-inline-edit-sizes' ).find( 'ul li' ).length >= 3 )
	    			jQuery( this ).hide();
				
	    		jQuery( this ).closest( '#tf-inline-edit-sizes' ).find( 'ul li.hidden' ).first().clone().insertBefore(jQuery(this ).closest( '#tf-inline-edit-sizes' ).find( 'ul li.hidden' )).removeClass( 'hidden' );
	    		
	    	} );
	    	
	    	jQuery( '.tf-inline-edit-remove-variant' ).live('click', function(e) {
	    		e.preventDefault();
	    		jQuery( this ).closest( 'li' ).remove();
	    		jQuery( "#tf-inline-edit-add-new-size" ).show();
	    	} );
	    	
	    	jQuery( 'a.editinline' ).live( 'click', function() {
	    		
	    		//cancel any open ones
	    		if ( jQuery( "tr.inline-edit-row" ).length )
	    			jQuery( "tr.inline-edit-row a.cancel" ).click();
	    		
	    		//clean up anyting from before
	    		for( var i = 0; i < TFInlineAddedElements.length; i++ ) {
		    		jQuery( TFInlineAddedElements[i] ).remove();
		    	}
		    	TFInlineAddedElements = [];
	    		
	    		jQuery( "#tf-inline-edit-image #_tf_events_image_container" ).html( '' );
	    		jQuery( "#tf-inline-edit-description textarea" ).html( '' );
	    		jQuery( "#tf-inline-edit-description input[type='hidden']" ).val( '' );
	    		jQuery( "#tf-inline-edit-image input#_tf_events_image" ).val( '' );
	    		
	    		var data = window[jQuery( this).closest('tr').find('.tf-inline-data-variable').text()];
	    		
	    		// Dates
                        
                        // *** Commented out for Datepicker ***
	    		jQuery( '#inlineedit .inline-edit-date' ).closest( '.inline-edit-col').find('#tf-inline-edit-dates .start-date').html( data.start_date );
	    		jQuery( '#inlineedit .inline-edit-date' ).closest( '.inline-edit-col').find('#tf-inline-edit-dates .end-date').html( data.end_date );
	    		
				//image
	    		if ( data.image_id )
		    		jQuery( "#tf-inline-edit-image #_tf_events_image_container" ).html( '<span class="image-wrapper" id="' + data.image_id + '"><img src="' + data.image + '" /><a class="delete_custom_image" rel="_tf_events_image:' + data.image_id + '">Remove</a></span>' );
		    	else
		    		jQuery( "#tf-inline-edit-image #_tf_events_image_container" ).html( '<span class="image-wrapper no-attached-image"></span>' );
	    		//description
	    		jQuery( "#tf-inline-edit-description textarea" ).html( data.description );
	    		//jQuery( "#tf-inline-edit-description input[type='hidden']" ).val( data.description );
	    		jQuery( "#tf-inline-edit-image input#_tf_events_image" ).val( data.image_id );
				
				setTimeout( function() {
				
					jQuery( '#event_end_date-day' ).datepicker();
					jQuery( '#event_start_date-day' ).datepicker();
				}, 1);

	    		
	    	} );
	    	
	    	//re-modify the Edit links when quick edit finished
	    	jQuery( document ).ajaxComplete( function(e, xhr, settings) { 
	    		
	    		jQuery( '.row-actions .edit' ).css( 'display', 'none' );
		    	jQuery( '.row-actions .editinline' ).text( '<?php _e( 'Edit' ); ?>' );
		    	jQuery( '.row-title' ).addClass( 'editinline' );
	    		
	    	} ); 

	    	
	    	//sync description teaxtarea and input
	    	jQuery( "#tf-inline-edit-description textarea" ).change( function() {

	    		jQuery( "#tf-inline-edit-description input[type='hidden']" ).val( jQuery( "#tf-inline-edit-description textarea" ).val() );
	    	} );
	    	
	    	jQuery( '#tf-inline-edit-image' ).appendTo( jQuery("#inlineedit .inline-edit-status").parent() );
	    	jQuery( '#tf-inline-edit-description' ).appendTo( jQuery("#inlineedit .inline-edit-status").parent() );
	    } );
	</script>
	<?php
}

/**
 * Adds a JSON object to each table row in the manage food menu.
 * 
 * @param int $post_id
 */
function tf_events_inline_data( $post_id ) {
	
	$post = get_post( $post_id );
	
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'width=80&height=80&crop=1' );
	if ( is_array( $image ) )
		$image = reset( $image );
		
	$start_date_selector = new TFDateSelector( 'event_start_date' );
	$start_date_selector->setDate( get_post_meta( $post_id, 'tf_events_startdate', true ) );
	
	$end_date_selector = new TFDateSelector( 'event_end_date' );
	$end_date_selector->setDate( get_post_meta( $post_id, 'tf_events_enddate', true ) );
	
	$data = array(
		'image'			=> get_post_thumbnail_id( $post_id ) ? $image : '',
		'image_id'		=> get_post_thumbnail_id( $post_id ),
		'description' 	=> strip_tags( $post->post_content, '<br><p>' ),
		'start_date' 	=> $start_date_selector->getDatePickerHTML(),
		'end_date'		=> $end_date_selector->getDatePickerHTML()
	);
	?>
	<script type="text/javascript">
		var TFInlineData<?php echo $post_id ?> = <?php echo json_encode( $data ) ?>;
	</script>
	<span class="tf-inline-data-variable hidden">TFInlineData<?php echo $post_id ?></span>

	<?php
}

/**
 * Catches the inline edit save post form.
 * 
 * @param int $post_id
 * @param object $post
 */
function tf_events_inline_edit_save_post( $post_id, $post ) {
		
	if ( !isset( $_POST['_inline_edit'] ) || $post->post_type !== 'tf_events' )
		return;

	$start_date = new TFDateSelector( 'event_start_date' );
	update_post_meta( $post_id, 'tf_events_startdate', $start_date->getDateFromPostDataDatePicker() );
	
	$end_date = new TFDateSelector( 'event_end_date' );
	update_post_meta( $post_id, 'tf_events_enddate', $end_date->getDateFromPostDataDatePicker() );
	
	// description
	global $wpdb;
	$data['post_content'] = strip_tags( stripslashes( $_POST['tf_description'] ), '<br><p>' );
	
	$wpdb->update( $wpdb->posts, $data, array( 'ID' => $post_id ) );
	
	//post image
	set_post_thumbnail( $post_id, ( int ) $_POST['_tf_events_image'] );
}
add_action( 'save_post', 'tf_events_inline_edit_save_post', 10, 2 );


function quick_edit_events_styles() {
    global $post_type;
    if ( 'tf_events' != $post_type )
        return;
    wp_enqueue_style('ui-datepicker', TF_URL . '/assets/css/jquery-ui-1.8.9.custom.css', array(), TF_VERSION );
}

function quick_edit_events_scripts() {
    global $post_type;
    wp_enqueue_script('jquery-ui', TF_URL . '/assets/js/jquery-ui-1.8.9.custom.min.js', array( 'jquery'), TF_VERSION );
    wp_enqueue_script('ui-datepicker', TF_URL . '/assets/js/jquery.ui.datepicker.js', array(), TF_VERSION );
    wp_enqueue_script('ui-datepicker-settings', TF_URL . '/assets/js/themeforce-admin.js', array( 'jquery'), TF_VERSION  );
    // - pass local img path to js -
    $datepicker_img = TF_URL . '/assets/images/ui/icon-datepicker.png';

}


add_action( 'init', 'quick_edit_events_scripts', 1000 );

add_action( 'init', 'quick_edit_events_styles', 1000 );
