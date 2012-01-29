<?php

class TF_Upload_Image_Well {
	
	public $save_on_upload;
	public $allowed_extensions;
	public $drop_text;
    
    function __construct( $id, $attachment_id, $size = '', $drop_text = 'Drop image here', $allowed_extensions = array( 'jpg', 'jpeg', 'png', 'gif' ) ) {
    	$this->id 				= $id;
    	$this->attachment_id 	= $attachment_id;
    	$this->size 			= wp_parse_args( $size, 'width=440&height=200&crop=1' );
    	$this->drop_text 		= $drop_text;
    	$this->allowed_extensions = $allowed_extensions;
    	$this->save_on_upload	= false;
    	
    	if ( empty( $this->size['width'] ) )
    		$this->size['width'] = '440';
    	
    	if ( empty( $this->size['height'] ) )
    		$this->size['height'] = '200';
    	
    	if ( ! is_string( $size ) )
	    	$this->size_str = sprintf( 'width=%d&height=%d&crop=%s', $this->size['width'], $this->size['height'], $this->size['crop'] );
	    
	    else
	    	$this->size_str = $size;
    }
	
	static function enqueue_scripts() {
		
		require_once( ABSPATH . 'wp-admin/includes/template.php' );		
		
		global $post;
    	// Enqueue same scripts and styles as for file field

    	wp_enqueue_script( 'plupload-all' );
    	wp_enqueue_style( 'tf-well-plupload-image', TF_URL . '/core_options/css/plupload-image.css', array() );

    	wp_enqueue_script( 'tf-well-plupload-image', TF_URL . '/core_options/js/plupload-image.js', array( 'jquery-ui-sortable', 'wp-ajax-response', 'plupload-all' ), 1 );
    	wp_localize_script( 'tf-well-plupload-image', 'tf_well_plupload_defaults', array(
    		'runtimes'				=> 'html5,silverlight,flash,html4',
    		'file_data_name'		=> 'async-upload',
    		'multiple_queues'		=> true,
    		'max_file_size'			=> wp_max_upload_size().'b',
    		'url'					=> admin_url('admin-ajax.php'),
    		'flash_swf_url'			=> includes_url( 'js/plupload/plupload.flash.swf' ),
    		'silverlight_xap_url'	=> includes_url( 'js/plupload/plupload.silverlight.xap' ),
    		'filters'				=> array( array( 'title' => __( 'Allowed Image Files' ), 'extensions' => '*' ) ),
    		'multipart'				=> true,
    		'urlstream_upload'		=> true,			
    		// additional post data to send to our ajax hook
    		'multipart_params'		=> array(
    			'_ajax_nonce'	=> wp_create_nonce( 'plupload_image' ),
    			'action'    	=> 'plupload_image_upload'
    		)

    	));
	}
	
    /**
     * Upload
     * Ajax callback function
     * 
     * @return error or (XML-)response
     */
    static function handle_upload () {
    	header( 'Content-Type: text/html; charset=UTF-8' );

    	if ( ! defined('DOING_AJAX' ) )
    		define( 'DOING_AJAX', true );

    	check_ajax_referer('plupload_image');

    	$post_id = 0;
    	if ( is_numeric( $_REQUEST['post_id'] ) )
    		$post_id = (int) $_REQUEST['post_id'];

    	// you can use WP's wp_handle_upload() function:
    	$file = $_FILES['async-upload'];
    	$file_attr = wp_handle_upload( $file, array('test_form'=>true, 'action' => 'plupload_image_upload') );
    	$attachment = array(
    		'post_mime_type'	=> $file_attr['type'],
    		'post_title'		=> preg_replace( '/\.[^.]+$/', '', basename( $file['name'] ) ),
    		'post_content'		=> '',
    		'post_status'		=> 'inherit'
    	);

    	// Adds file as attachment to WordPress
    	$id = wp_insert_attachment( $attachment, $file_attr['file'], $post_id );
    	if ( ! is_wp_error( $id ) )
    	{
    		$response = new WP_Ajax_Response();
    		wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file_attr['file'] ) );
    		if ( isset( $_REQUEST['field_id'] ) ) 
    		{
    			// Save file ID in meta field
    			add_post_meta( $post_id, $_REQUEST['field_id'], $id, false );
    		}
    		
    		$src = wp_get_attachment_image_src( $id, $_REQUEST['size'] );
    		
    		$response->add( array(
    			'what'			=>'tf_well_image_response',
    			'data'			=> $id,
    			'supplemental'	=> array(
    				'thumbnail'	=>  $src[0],
    				'edit_link'	=> get_edit_post_link($id)
    			)
    		) );
    		$response->send();
    	}

    	exit;
    }

    /**
     * Enqueue scripts and styles
     * 
     * @return void
     */
    public function admin_print_styles() 
    {
    	return self::enqueue_scripts();
    }

    /**
     * Get field HTML
     *
     * @param string $html
     * @param mixed  $meta
     * @param array  $field
     *
     * @return string
     */
    public function html()  {
    	// Filter to change the drag & drop box background string
    	$drop_text = $this->drop_text;
    	$extensions = implode( ',', $this->allowed_extensions );
    	$i18n_select	= 'Select Files';
    	$img_prefix		= $this->id;
    	$style = sprintf( 'width: %dpx; height: %dpx;', $this->size['width'], $this->size['height'] );
    	
    	$html = "<div style='$style' class='hm-uploader " . ( $this->attachment_id ? 'with-image' : '' ) . "' id='{$img_prefix}-container'>";
    	
    	$html .= "<input type='hidden' class='field-id rwmb-image-prefix' value='{$img_prefix}' />";
    	$html .= "<input type='hidden' class='field-val' name='{$this->id}' value='{$this->attachment_id}' />";
    	
    	echo $html;
    	
    	$html = '';
    	?>
    	<div style="<?php echo $style ?> <?php echo $this->attachment_id ? '' : 'display: none;' ?>" class="current-image">
    		<?php if ( $this->attachment_id ) : ?>
	    		<?php echo wp_get_attachment_image( $this->attachment_id, $this->size, false, 'id=' . $this->id ) ?>
	    	<?php else : ?>
	    		<img src="" />
    		<?php endif; ?>
    		<div class="image-options">
    			<a href="#" class="delete-image">Delete</a>
    		</div>
    	</div>
    	<?php
    	
    	// Show form upload
    	$html = "
    	<div style='{$style}' id='{$img_prefix}-dragdrop' data-extensions='$extensions' data-size='{$this->size_str}' class='rwmb-drag-drop upload-form'>
    		<div class = 'rwmb-drag-drop-inside'>
    			<p>{$drop_text}</p>
				<p>or</p>
    			<p><input id='{$img_prefix}-browse-button' type='button' value='{$i18n_select}' class='button' /></p>
    		</div>
    	</div>";

    	?>
    	<div style="<?php echo $style ?>" class="loading-block hidden">
    		loading...
    	</div>
    	<?php

    	$html .= "</div>";

    	echo $html;
    }
}

add_action( 'wp_ajax_plupload_image_upload', array( 'TF_Upload_Image_Well', 'handle_upload' ) );