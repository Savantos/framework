<?php

/*
 * Goal of TF Slider
 * 
 * - Create a Slider Post Type
 * - Create a Single Options Page whereby:
 * --- All Sliders are created/modified/deleted
 * --- Sorted via jQuery UI
 * 
 */


// Create Slider Post Type

function create_slider_postype() {

    $args = array(
        'label' => __('Slider'),
        'can_export' => true,
        'show_ui' => false,
        'show_in_nav_menus' => false,
        '_builtin' => false,
        'capability_type' => 'post',
        'menu_icon' => get_bloginfo('template_url').'/themeforce/assets/images/food_16.png',
        'hierarchical' => false,
        'rewrite' => array( "slug" => "food-menu" ),
        'supports'=> array('title', 'thumbnail', 'editor', 'custom-fields') ,
    );

	register_post_type( 'tf_slider', $args);

}

add_action( 'init', 'create_slider_postype' );

// Register Page

function themeforce_slider_addpage() {
    add_submenu_page('themes.php','Slider Page Title', 'Slides', 'manage_options', 'themeforce_slider', 'themeforce_slider_page');
}

add_action('admin_menu','themeforce_slider_addpage');

// Load jQuery & relevant CSS

// js
function themeforce_slider_scripts() {
    // standards
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('jquery-ui-draggable');
    wp_enqueue_script('thickbox');
    // other
    wp_enqueue_script( 'jalerts', TF_URL . '/assets/js/jquery.alerts.js' );
    // wp_enqueue_script( 'media-uploader-extensions', TF_URL . '/assets/js/media-uploader.extensions.js' );
    // option page settings
    wp_enqueue_script( 'tfslider', TF_URL . '/assets/js/themeforce-slider.js', array('jquery'));
}

add_action( 'admin_print_scripts-appearance_page_themeforce_slider', 'themeforce_slider_scripts' );

// css
function themeforce_slider_styles() {
    wp_enqueue_style( 'jalerts', TF_URL . '/assets/css/jquery.alerts.css');
    wp_enqueue_style( 'tfslider', TF_URL . '/assets/css/themeforce-slider.css');
}

add_action( 'admin_print_styles', 'themeforce_slider_styles' );

// Create Page
// TODO Add functionality to edit existing slides.

function themeforce_slider_page() {
    ?>
    <div class="wrap" id="tf-slider-page">
    <div id="tf-options-page">    
    <?php screen_icon(); ?>
    <h2>Slider Options</h2>
    <h3>Manage Slides</h3>
    <form method="post" action="" name="" onsubmit="return checkformf(this);">
    <ul id="tf-slider-list"> 
    
    <?php
    // Query Custom Post Types  
            $args = array(
                'post_type' => 'tf_slider',
                'post_status' => 'publish',
                'orderby' => 'meta_value_num',
                'meta_key' => '_tfslider_order',
                'order' => 'ASC',
                'posts_per_page' => 99
            );
			
            // - query -
            $my_query = null;
            $my_query = new WP_query($args);
			

            while ($my_query->have_posts()) : $my_query->the_post();

            // - variables -
			
            $custom = get_post_custom(get_the_ID());
            $id = ($my_query->post->ID);
            $order = $custom["_tfslider_order"][0];
            $type = $custom["_tfslider_type"][0];
                if ($type=='image') {$imageselect = ' selected="selected"';} else {$imageselect = '';}
                if ($type=='content') {$contentselect = ' selected="selected"';} else {$contentselect = '';}
            $title = $custom["tfslider_title"][0];
            $link = $custom["tfslider_link"][0];
            $button = $custom["tfslider_button"][0];
            $image = $custom["tfslider_image"][0];
            $thumbnail = wpthumb( $image, 'width=250&height=100&crop=1', false);
                    
             echo '<li id="listItem_' . $id . '" class="menu-item-handle slider-item">';
             echo '<div class="slider-controls">';
                 echo '<div class="handle"></div>';
                 echo '<div class="slider-edit"></div>';
                 echo '<div class="slider-delete"></div>';
             echo '</div>';
             
             // ID
             echo '<input type="hidden" name="' . 'slider[id][' . $id . ']" value="' . $id . '" />';
             
             // Thumbnail
             echo '<div class="slider-thumbnail">';
             if($thumbnail) {echo '<img src="' . $thumbnail . '"/>';} else { echo '<img src="' . TF_URL . '/assets/images/slider-empty.jpg">';}
             echo '</div>';
             
             // Content
             echo '<div class="slider-content">';
             echo '<select style="display:none;margin-bottom:15px;" name="' . 'slider[type][' . $id . ']" id="slidertype" class="postform" >';
             echo '<option value="image"'. $imageselect .'>Image Alone</option> ';
             echo '<option value="content"'. $contentselect .'>Image & Text</option>';
             echo '</select>';
             echo '<h3><span>' . $title . '</span><input placeholder=" Title (Optional)" style="display:none;" type="text" name="' . 'slider[title][' . $id . ']" size="45" id="input-title" value="' . $title . '" /></h3>';
             echo '<p><span>' . get_the_content($id) . '</span><textarea placeholder=" Content (Optional)" style="display:none;" rows="5" cols="40" name="' . 'slider[content][' . $id . ']">' . get_the_content($id)  . '</textarea></p>';
             echo '<p><span>' . $link . '</span><input style="display:none;" placeholder=" Link (Optional)" type="text" name="' . 'slider[link][' . $id . ']" size="45" id="input-title" value="' . $link  . '" /></p>';
             echo '<p><span>' . $button . '</span><input style="display:none;" placeholder=" Button Text (Optional)"type="text" name="' . 'slider[button][' . $id . ']" size="45" id="input-title" value="' . $button  . '" /></p>';
             echo '</div>';
             
             // Update Sortable List
             echo '<input type="hidden" name="' . 'slider[order][' . $id . ']" value="' . $order . '" id="input-title"/>';
             
             // Update Delete Field
             echo '<input type="hidden" name="' . 'slider[delete][' . $id . ']" value="false" id="input-title"/>';
             echo '</li>';     
                         
             endwhile;   
    ?>

    </ul> 
    
    <input type="hidden" name="update_post" value="1"/> 
    
    <input style="margin-top:10px" type="submit" name="updatepost" value="Update Slides" id="tf-submit" /> 
    </form>
    <div style="clear:both"></div>
<?php
// Create New Slide
?>
    
    <div id="tf-options-panel">
    
    <h3>Create New Slide</h3>
    <div class="tf-settings-wrap">
    <form class="form-table"method="post" action="" name="" onsubmit="return checkformf(this);">
    
    <table>
            
            <?php if( TF_SLIDERJS == 'bxslider' ) { ?>
            <tr>
                <th><label>Type of Slide<span class="required">*</span></label></th>
                <td><ul>
                    <select name='_tfslider_type' id='slidertype_new' class='postform' > 
                        <option value="image">Image Alone</option> 
                        <option value="content">Image & Text</option> 
                    </select> 
                </ul></td>
            </tr>   
            <?php } else { echo '<input type="hidden" name="_tfslider_type" value="image">';} ?>
            
            <tr>
                <?php // TODO Would be nice to have the 250x100 thumbnail replace the upload button once the image is ready ?>
                <th><label>Pick an Image<span class="required">*</span></label></th><!-- <input id="tfslider_image" type="text" name="_tfslider_image" value="" /><input id="upload_image_button" type="button" value="Upload Image" /> -->
                <td><?php
                if ( get_settings( $value['id'] ) != "") { $val = stripslashes(get_settings( $value['id'])  ); } else { $val =  $value['std']; }
                ?>
                <?php echo tf_optionsframework_medialibrary_uploader( 'tfslider_image', $val ); ?>
                </td>
            </tr>
            <?php if( TF_THEME != 'fineforce' ) { ?>
            <tr>
                <th><label>Slider Header / Title</label></th>
                    <td><input  placeholder="Header (Optional)" type="text" name="tfslider_title" size="45" id="input-title"/></td>
            </tr>
            <?php ;} ?>
            <tr>
                <th><label>Slide Link</label></th>
                <td>
                    <input type="text"  placeholder="http:// (Optional)" name="tfslider_link" size="45" id="input-title"/><br />
                    <span class="desc">If you'd like your slide to link to a page, enter the URL here.</span>
                </td>
            </tr> 

   

            <tr class="extra-options">

                <th><label>Slide Description</label></th>
                <td><textarea rows="5"  placeholder="Content (Optional)" name="post_content" cols="66" id="text-desc"></textarea></td>
            </tr>

            
            <tr class="extra-options">

                <th><label>Button Text</label></th>
                <td><input type="text"  placeholder="Button Text (Optional)" name="tfslider_button" size="45" id="input-title"/>
                <span class="desc">If you've chosen a link above, it'll turn into a button for content slides.</span></td>
                
            </tr>

        </table>
        </div>
        <input type="hidden" name="new_post" value="1"/> 
        
        <input style="margin-top:25px" type="submit" name="submitpost" id="tf-submit" value="Create New Slide"/> 
        
    </form>
    </div>
    </div>
</div>
    <?php
        
}

// Save New Slide

function themeforce_slider_catch_submit() {
        // Grab POST Data
        if(isset($_POST['new_post']) == '1') {
        $post_title = 'Slide'; // New - Static as one field is always required between post title & content. This field will always be hidden now.
        $slide_title = $_POST['tfslider_title']; // New
        $post_content = $_POST['post_content'];
        $slidertype = $_POST['_tfslider_type'];
        $imageurl = $_POST['tfslider_image'];
        if (!$imageurl) {$imageurl = TF_URL . '/assets/images/slider-empty.jpg'; }
        $link = $_POST['tfslider_link'];
        $button = $_POST['tfslider_button'];
        $new_post = array(
              'ID' => '',
              'post_type' => 'tf_slider',
              'post_author' => $user->ID, 
              'post_content' => $post_content,
              'post_title' => $post_title,
              'post_status' => 'publish',
            );

        // Create New Slide
        $post_id = wp_insert_post($new_post);
        
        // Update Meta Data
        $order_id = intval($post_id)*100;
        
        update_post_meta( $post_id,'_tfslider_type', $slidertype);
        update_post_meta( $post_id,'tfslider_title', $slide_title); // New
        update_post_meta( $post_id,'_tfslider_order', $order_id);
        update_post_meta( $post_id,'tfslider_image', $imageurl);
        if ($link) {update_post_meta( $post_id,'tfslider_link', $link);}
        if ($button) {update_post_meta( $post_id,'tfslider_button', $button);}
        
        // Exit
        wp_redirect(wp_get_referer());
        exit;
        }
}

add_action('admin_init', 'themeforce_slider_catch_submit');

// Update Slide
// TODO Add rest of slide content (only testing sort order atm)

function themeforce_slider_catch_update() {
    
    if(isset($_POST['update_post']) == '1') {
    foreach ( $_POST['slider']['order'] as $key => $val ) {
        
        // Grab General Data
        $my_post = array();
        $my_post['ID'] = $_POST['slider']['id'][$key];
        // New - not necessary - $my_post['post_title'] = $_POST['slider']['title'][$key];
        $my_post['post_content'] = $_POST['slider']['content'][$key];
        
        // Grab Delete Setting
        $delete = $_POST['slider']['delete'][$key];
              
        if ($delete == 'true') {
            
            // Delete selected sliders
            wp_delete_post( $key, true );
        
                
        } else {

            // Update Regular Post
            wp_update_post( $my_post );
            
            // Update Meta
            $type = $_POST['slider']['type'][$key];
            $title = $_POST['slider']['title'][$key]; // new
            $button = $_POST['slider']['button'][$key];
            $link = $_POST['slider']['link'][$key];
            $slider_order = intval($_POST['slider']['order'][$key]);
            update_post_meta($key, '_tfslider_type', $type);
            update_post_meta($key, 'tfslider_title', $title); // new
            if ($button) {update_post_meta($key, 'tfslider_button', $button);}
            if ($link) {update_post_meta($key, 'tfslider_link', $link);}
            update_post_meta($key, '_tfslider_order', $slider_order);
        }
    }    
        
    wp_redirect(wp_get_referer());
    exit;
    }
}

add_action('admin_init', 'themeforce_slider_catch_update');


//TODO Change function to match custom post types, not options.
//TODO Could benefit from using transients api for scalability
function themeforce_slider_display() {

    // Query Custom Post Types  
        $args = array(
            'post_type' => 'tf_slider',
            'post_status' => 'publish',
            'orderby' => 'meta_value_num',
            'meta_key' => '_tfslider_order',
            'order' => 'ASC',
            'posts_per_page' => 99
        );

        // - query -
        $my_query = null;
        $my_query = new WP_query($args);

        $c = 1;
        
        while ($my_query->have_posts()) : $my_query->the_post();
        
            // - variables -
            $custom = get_post_custom(get_the_ID());
            $id = ($my_query->post->ID);
            $title = $custom["tfslider_title"][0];
            $content = get_the_content($id);
            $order = $custom["_tfslider_order"][0];
            $type = $custom["_tfslider_type"][0];
            $image = $custom["tfslider_image"][0];
            $link = $custom["tfslider_link"][0];
            $button = $custom["tfslider_button"][0];
       
            // output
            // todo if-else on TF_SLIDERTYPE
            
            // update mobile bg if not set yet
            if ($c == 1 && get_option('tf_mobilebg') == '') {update_option('tf_mobilebg', $image);}
            $c++;
            
            
            if( TF_THEME == 'baseforce' )
                {
                $b_image = wpthumb( $image, 'width=960&height=300&crop=1', false);
                echo '<li>';
                if ($link && $type == 'image') {echo '<a href="' . $link . '">';}
                echo '<div style="width:960px;height:300px;background: url(' . $b_image . ')">';
                if ($type == 'content')
                    {
                    echo '<div class="content-text">';
                        if ($title) {echo '<h2>'. $title . '</h2>';}
                        if ($content) {echo '<p>'. $content .'</p>';}
                        if ($button && $link) {echo '<a href="' . $link . '"><div class="slider-button">' . $button . '</div></a>';}
                    echo '</div>';
                    }
                echo '</div>';
                if ($link && $type == 'image') {echo '</a>';}
                echo '</li>';
                }
            
             if( TF_THEME == 'chowforce' )
                {
                if ($type == 'content') 
                    {
                    $c_s_image = wpthumb( $image, 'width=540&height=300&crop=1', false);
                    echo '<li><div class="slidetext">';
                    if ( $title ) {echo '<h3>' . $title . '</h3>';}
                    echo '<p>' . $content . '</p>';
                    if ( $link ) {echo '<a href="' . $link . '"><div class="slidebutton">' . $button . '</div></a>';}
                    echo '</div>';
                    echo '<div class="slideimage"><img src="' . $c_s_image . '" alt="' . __('Slide', 'themeforce') . '"></div></li>';
                } else {
                    $c_l_image = wpthumb( $image, 'width=960&height=300&crop=1', false);
                    echo '<li><div class="slideimage-full"><a href="' . $slink . '"><img src="' . $c_l_image . '" alt="' . __('Slide', 'themeforce') . ' ' . $c . '"></a></div></li>';
                    }
                }
                
              if( TF_THEME == 'pubforce' )
                {
                if ($type == 'content') 
                    {
                    $c_s_image = wpthumb( $image, 'width=540&height=300&crop=1', false);
                    echo '<li><div class="slidetext">';
                    if ( $title ) {echo '<h3>' . $title . '</h3>';}
                    echo '<p>' . $content . '</p>';
                    if ( $link ) {echo '<a href="' . $link . '"><div class="slidebutton">' . $button . '</div></a>';}
                    echo '</div>';
                    echo '<div class="slideimage" style="background:url(' . $c_s_image . ') no-repeat;" alt="' . __('Slide', 'themeforce') . '"></div></li>';
                } else {
                    $c_l_image = wpthumb( $image, 'width=540&height=300&crop=1', false);
                    echo '<li><div class="slideimage" style="background:url(' . $c_l_image . ') no-repeat;" alt="' . __('Slide', 'themeforce') . '"></div></li>';
                    }
                }   
                
              if( TF_THEME == 'fineforce' )
                {
                    echo '<li>';
                        if ( $link ) {echo '<a href="' . $link . '">';}
                            $c_l_image = wpthumb( $image, 'width=1000&height=250&crop=1', false);
                            echo '<div class="slideimage" style="background:url(' . $c_l_image . ') no-repeat;" alt="' . __('Slide', 'themeforce') . '"></div>';
                        if ( $link ) {echo '</a>';}
                    echo '</li>';
                    
                }   
             
                
             // fallback check   
             $emptycheck[] = $image;   
                    
        endwhile;
        
        // fallback functions when no slides exist
        
        if ( $emptycheck == '' ) {
            
            if( TF_THEME == 'pubforce' ) {
                echo '<li><div class="slideimage" style="background:url(' . get_bloginfo('template_url') . '/images/defaults/slide1.jpg) no-repeat;" alt="Slide"></li>';
                echo '<li><div class="slideimage" style="background:url(' . get_bloginfo('template_url') . '/images/defaults/slide2.jpg) no-repeat;" alt="Slide"></li>';
                echo '<li><div class="slideimage" style="background:url(' . get_bloginfo('template_url') . '/images/defaults/slide3.jpg) no-repeat;" alt="Slide"></li>';
            }
            
            if( TF_THEME == 'fineforce' ) {
                echo '<li><div class="slideimage" style="background:url(' . get_bloginfo('template_url') . '/images/default_food_1.jpg) no-repeat;" alt="Slide"></li>';
                echo '<li><div class="slideimage" style="background:url(' . get_bloginfo('template_url') . '/images/default_food_2.jpg) no-repeat;" alt="Slide"></li>';
                echo '<li><div class="slideimage" style="background:url(' . get_bloginfo('template_url') . '/images/default_food_3.jpg) no-repeat;" alt="Slide"></li>';
            }
            
            }

        }
?>