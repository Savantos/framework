<?php /*

Theme-Force.com - WordPress Framework (v 3.2.2)
===================================================

Introduction
------------

The Theme Force Framework is the most comprehensive solution for restaurant websites based on WordPress. It is
structured as a modular feature-set highly relevant to industry needs.

Resources
---------

Developer Homepage: 	http://www.theme-force.com/developers
GitHub Homepage: 	https://github.com/themeforce/framework
Discussion & News: 	http://www.facebook.com/themeforce

 /* Definitions
=========================================*/
 
define( 'TF_DIR_SLUG', end( explode( DIRECTORY_SEPARATOR, dirname( __FILE__ ) ) ) );
define( 'TF_PATH', dirname( __FILE__ ) );
define( 'TF_URL', get_bloginfo( 'template_directory' ) . '/' . TF_DIR_SLUG );
define ('TF_VERSION', '3.2.3');

/* Theme Force Core Tools
=========================================*/

// Template Hooks
require_once( TF_PATH . '/core_general/tf.template-hooks.php' );
require_once( TF_PATH . '/core_general/tf.business-general.php' );
require_once( TF_PATH . '/core_general/tf.facebook.php' );
                
// Business Options
if( current_theme_supports( 'tf_settings_api' ) )     
    require_once( TF_PATH . '/core_options/tf.options-master.php' );

// Shortcodes - Business
require_once( TF_PATH . '/core_general/tf.business-shortcodes.php' );        
	
// Common Assets
require_once( TF_PATH . '/core_general/tf.assets.php' );
require_once( TF_PATH . '/core_general/tf.slider.php' );
require_once( TF_PATH . '/core_general/tf.mobile.php' );
require_once( TF_PATH . '/core_colors/tf.colors.php' );
    
if ( get_option('tf_sliderconversion') != 'true' ) {
	require_once( TF_PATH . '/core_general/tf.slider.update.php' );
}
        
// Food Menu
if( current_theme_supports( 'tf_food_menu' ) )
	require_once( TF_PATH . '/core_food-menu/tf.food-menu.php' );

// Events
if( current_theme_supports( 'tf_events' ) )
	require_once( TF_PATH . '/core_events/tf.events.php' );

if( current_theme_supports( 'tf_fullbackground' ) )
	require_once( TF_PATH . '/core_options/tf.options-full-background.php' );
	
// Google Maps
require_once( TF_PATH . '/api_google/tf.googlemaps.shortcodes.php' );

// Schema Functions
require_once( TF_PATH . '/core_seo/tf.schema.php' );
	
// Widgets
require_once( TF_PATH . '/core_widgets/widget-text-widget-on-page.php' );

if( current_theme_supports( 'tf_widget_opening_times' ) )
	require_once( TF_PATH . '/core_widgets/widget-openingtimes.php' );

if( current_theme_supports( 'tf_widget_google_maps' ) )
	require_once( TF_PATH . '/core_widgets/widget-googlemaps.php' );
	
if( current_theme_supports( 'tf_widget_payments' ) )
	require_once( TF_PATH . '/core_widgets/widget-payments.php' );

//Enqueue common.js script
wp_enqueue_script('common-js', TF_URL . '/assets/js/common.js', array('jquery'), TF_VERSION );

	
/* 3rd Party Tools
=========================================*/

// WP Thumb
require_once( TF_PATH . '/wpthumb/wpthumb.php' ); 
require_once( TF_PATH . '/tf.rewrite.php' );

/* SEO & Semantic Connections
=========================================*/	
	
// Facebook Open Graph Protocol
require_once( TF_PATH . '/core_seo/tf.open_graph_protocol.php' );
require_once( TF_PATH . '/core_widgets/widget-facebook-likebox.php' );
require_once( TF_PATH . '/core_widgets/widget-facebook-facepile.php' );

/* API Connections
=========================================*/	

// Foursquare
if( current_theme_supports( 'tf_foursquare' ) ) {
	require_once( TF_PATH . '/api_foursquare/tf.foursquare.php' ); 
	require_once( TF_PATH . '/core_widgets/widget-foursquare-photos.php' );
	require_once( TF_PATH . '/core_widgets/widget-foursquare-tips.php' );
	/* require_once( TF_PATH . '/widgets/widget-foursquare-herenow.php' ); WIP */
}

// Yelp
if( current_theme_supports( 'tf_yelp' ) ) {
	require_once( TF_PATH . '/api_yelp/tf.yelp.php' );
}

// OpenTable

require_once( TF_PATH . '/api_opentable/tf.opentable.php' );
require_once( TF_PATH . '/core_widgets/widget-opentable.php' );

// Gowalla
if( current_theme_supports( 'tf_gowalla' ) ) {
	// photos
	require_once( TF_PATH . '/api_gowalla/tf.gowalla.api-photos.php' );
	require_once( TF_PATH . '/core_widgets/widget-gowalla-photos.php' );
	// checkins
	require_once( TF_PATH . '/api_gowalla/tf.gowalla.api-checkins.php' );
	require_once( TF_PATH . '/core_widgets/widget-gowalla-checkins.php' );
}
// MailChimp
if( current_theme_supports( 'tf_mailchimp' ) )
	require_once( TF_PATH . '/api_mailchimp/mailchimp-widget.php' );

// Datepicker JS

function tf_sortable_admin_rows_scripts() {
	wp_enqueue_script('ui-datepicker-settings', TF_URL . '/assets/js/themeforce-admin.js', array('jquery'), TF_VERSION );

}
add_action( 'admin_print_scripts-edit.php', 'tf_sortable_admin_rows_scripts' );

/* Admin Global JS & Stylesheets
=========================================*/

function tf_less_js() {
        wp_enqueue_script('less-js', TF_URL . '/assets/js/less-1.1.3.min.js' );
        wp_enqueue_style('less-css', TF_URL . '/assets/css/styleguide/tf_styleguide.less' );
}
add_action('admin_enqueue_scripts','tf_less_js');



function enqueue_less_styles($tag, $handle) {
    global $wp_styles;
    $match_pattern = '/\.less$/U';
    if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
        $handle = $wp_styles->registered[$handle]->handle;
        $media = $wp_styles->registered[$handle]->args;
        $href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
        $rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
        $title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';

        $tag = "<link rel='stylesheet' id='$handle' $title href='$href' type='text/less' media='$media' />";
    }
    return $tag;
}
add_filter( 'style_loader_tag', 'enqueue_less_styles', 5, 2);

/* Food Menu Sorting
=========================================*/	

function tf_sortable_admin_rows_order_table_rows_hook() {
	if( !empty( $_GET['post_type'] ) && $_GET['post_type'] == 'tf_foodmenu' && !empty( $_GET['term'] ) )
		add_action( 'parse_query', 'tf_sortable_admin_rows_order_table_rows' );
}
add_action( 'load-edit.php', 'tf_sortable_admin_rows_order_table_rows_hook' );

function tf_sortable_admin_rows_order_table_rows( $wp_query ) {
	global $wpdb;
	$wp_query->query_vars['orderby'] = 'menu_order';
	$wp_query->query_vars['order'] = 'ASC';
}

function tf_sortable_admin_rows_column( $columns ) {

	if( !isset( $columns['tf_col_menu_cat'] ) || empty( $_GET['term'] ) )
		return $columns;
	
	$cols_1 = array_slice( $columns, 0, 1 );
	$cols_2 = array( 'tf_sortable_column' => '' );
	$cols_3 = array_slice( $columns, 1 );
	
	$columns = array_merge( $cols_1, $cols_2, $cols_3 );
	
	return $columns;
}
add_action( 'manage_edit-tf_foodmenu_columns', 'tf_sortable_admin_rows_column', 11 );

function tf_sortable_admin_row_cell( $column ) {
	
	if( $column != 'tf_sortable_column' )
		return $column;
	?>
	
	<a class="tf_sortable_admin_row_handle"></a>
	
	<?php
}
add_action( 'manage_posts_custom_column', 'tf_sortable_admin_row_cell' );

function tf_sortable_admin_row_request() {
	
	global $wpdb;
	
	foreach( (array) $_POST['posts'] as $key => $post_id ) {
		$wpdb->update( $wpdb->posts, array( 'menu_order' => $key ), array( 'ID' => $post_id ) );
	}
		
	exit;
}
add_action( 'wp_ajax_tf_sort_admin_rows', 'tf_sortable_admin_row_request' );

// Enqueue Admin Styles
 

function tf_enqueue_admin_css() {
    wp_enqueue_style('tf-functions-css', TF_URL . '/assets/css/admin.css', array(), TF_VERSION );
}
add_action('admin_init', 'tf_enqueue_admin_css');



/* Theme Force Upgrade Tools
=========================================
   You won't require this for a fresh install
*/	

require_once( TF_PATH . '/tf.upgrade.php' );


/* Remaining Functions
=========================================*/	

// Add Widget Styling within Widget Admin Area
 
function tf_add_tf_icon_classes_to_widgets() {
	?>
	 <script type="text/javascript">
     	jQuery( document ).ready( function() {
    		
     		jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( '_tf' ) > 1 )
					jQuery( object ).addClass('tf-admin-widget');
     		} );
			
			jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( '-gowalla-' ) > 1 )
					jQuery( object ).addClass('tf-gowalla-widget');
     		} );
			
			jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( '-fs-' ) > 1 )
					jQuery( object ).addClass('tf-fs-widget');
     		} );
			
			jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( '_mailchimp-' ) > 1 )
					jQuery( object ).addClass('tf-mailchimp-widget');
     		} );
			
			jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( 'googlemaps' ) > 1 )
					jQuery( object ).addClass('tf-google-widget');
     		} );
                	jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( '-fb_' ) > 1 )
					jQuery( object ).addClass('tf-facebook-widget');
     		} );
                        jQuery( '.widget' ).filter( function( i, object ) {
     			if( jQuery( this ).attr('id').indexOf( '-opentable-' ) > 1 )
					jQuery( object ).addClass('tf-opentable-widget');
     		} );
                        jQuery('.widget-top').prepend('<div class="widget-accent"></div>');
     		
     	} );
     </script>
     
	<?php
}
add_action( 'in_admin_footer', 'tf_add_tf_icon_classes_to_widgets' );

/**
 * Make some alterations to the menu that can't be done via add_menu_page().
 * 
 */

function tf_modify_admin_menu() {

	global $menu, $submenu;
	
	if( !empty( $submenu['themeforce_business_options'] ) )
		array_shift( $submenu['themeforce_business_options'] );

}
add_action( 'admin_menu', 'tf_modify_admin_menu', 11 );

/**
 * Adds the editor styles used for Food Menus setc in the TinyMCE
 * 
 * @access private
 */
function tf_add_editor_styles() {
	add_editor_style( 'framework/assets/css/editor-styles.css' );
}
add_action( 'admin_init', 'tf_add_editor_styles' );


/**
 * Enqueues the quick-add JS on manage post type pages that support 'tf_quick_add'.
 * 
 * @access private
 */
function tf_add_quick_add_js_to_supported_post_types() {

	global $current_screen;

	if( post_type_supports( $current_screen->post_type, 'tf_quick_add' ) )
		wp_enqueue_script( 'tf-quick-add', TF_URL . '/assets/js/themeforce-quick-add.js', array( 'jquery' ), TF_VERSION  );
	
}
add_action( 'load-edit.php', 'tf_add_quick_add_js_to_supported_post_types' );

function tf_modify_add_new_meni_item_for_quick_add() {

	global $menu, $submenu;
	
	foreach( $submenu as $handle => &$item ) {
		if( preg_match( '/post_type=([^&]+)/', $handle, $matches ) && post_type_supports( $matches[1], 'tf_quick_add' ) && $key = array_search( 'post-new.php?post_type=' . $matches[1], $item[10] ) )
			$item[10][$key] = $item[5][2] . '#quick-add-new';
	}
	

}
add_action( 'admin_menu', 'tf_modify_add_new_meni_item_for_quick_add', 1 );

function tf_admin_ajax_get_new_post_row() {
	
	require_once( ABSPATH . 'wp-admin/includes/class-wp-posts-list-table.php' );

	set_current_screen( 'edit-' . $_GET['post_type'] );
	$list_table = new WP_Posts_List_Table();

	$post_type = $_GET['post_type'];
	$post = get_default_post_to_edit( $post_type, true );
	
	$list_table->single_row( $post );
	
	exit;
}
add_action( 'wp_ajax_tf_get_new_post_row', 'tf_admin_ajax_get_new_post_row' );