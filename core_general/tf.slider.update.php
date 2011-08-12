<?php 

if ( get_option('tf_sliderconversion') != 'true' )
    {

    // PUBFORCE
    
    if ( TF_THEME == 'pubforce') 
            {

                $c = 1;

                // - loop -
                while($c <= 5):

                $raw_image = get_option('pubforce_slider_' . $c);
                $url = get_option('pubforce_slider_' . $c . 'url');
                $cap = get_option('pubforce_slider_' . $c . 'cap');

                // check if image exists
                if ( $raw_image != '' )
                    {
                    // show goodies
                    $post_title = 'Legacy Slide ' . $c;
                    $slidertype = 'image';
                    $imageurl = $raw_image;
                    $new_post = array(
                          'ID' => '',
                          'post_type' => 'tf_slider',
                          'post_author' => '1', 
                          'post_content' => '',
                          'post_title' => $post_title,
                          'post_status' => 'publish',
                        );

                    // Create New Slide
                    $post_id = wp_insert_post($new_post);

                    // Update Meta Data
                    $order_id = intval($post_id)*100;
                    update_post_meta( $post_id,'_tfslider_type', $slidertype);
                    update_post_meta( $post_id,'_tfslider_order', $order_id);
                    update_post_meta( $post_id,'tfslider_image', $imageurl);
                    }
                $c++;
                endwhile;
                update_option('tf_sliderconverion','true');
                }
    
    // CHOWFORCE
                
    if ( TF_THEME == 'chowforce') 
            {

                $c = 1;

                // - loop -
                while($c <= 5):

                $raw_image = get_option('chowforce_s' . $c .'_img');
                $stype = get_option('chowforce_s' . $c .'_type');
                if ($stype == 'textimage') {$slidertype = 'content';} else {$slidertype = 'image';}
                $sheader = '';
                $sdesc = '';
                $button = '';

                    // check type and load approriate options
                    if ( $type == 'content') {
                        $sheader = stripslashes(get_option('chowforce_s' . $c .'_h'));
                        $sdesc = stripslashes(get_option('chowforce_s' . $c .'_p'));
                        $button = stripslashes(get_option('chowforce_s' . $c .'_at'));
                    }
                    
                $link = get_option('chowforce_s' . $c .'_a');    
                    
                // check if image exists
                if ( $raw_image != '' )
                    {
                    // show goodies
                    $post_title = $sheader;
                    $slidertype = 'image';
                    $imageurl = $raw_image;
                    $new_post = array(
                          'ID' => '',
                          'post_type' => 'tf_slider',
                          'post_author' => '1', 
                          'post_content' => $sdesc,
                          'post_title' => $post_title,
                          'post_status' => 'publish',
                        );

                    // Create New Slide
                    $post_id = wp_insert_post($new_post);

                    // Update Meta Data
                    $order_id = intval($post_id)*100;
                    update_post_meta( $post_id,'_tfslider_type', $slidertype);
                    update_post_meta( $post_id,'_tfslider_order', $order_id);
                    update_post_meta( $post_id,'tfslider_image', $imageurl);
                    if ($link) {update_post_meta( $post_id,'tfslider_link', $link);}
                    if ($button) {update_post_meta( $post_id,'tfslider_button', $button);}
                    }
                $c++;
                endwhile;
                update_option('tf_sliderconverion','true');
                }                
    
    // FINEFORCE
    
    if ( TF_THEME == 'fineforce') 
            {

                $c = 1;

                // - loop -
                while($c <= 5):

                $raw_image = get_option('fineforce_slider_' . $c);
                $url = get_option('fineforce_slider_' . $c . 'url');
                $cap = get_option('fineforce_slider_' . $c . 'cap');

                // check if image exists
                if ( $raw_image != '' )
                    {
                    // show goodies
                    $post_title = 'Legacy Slide ' . $c;
                    $slidertype = 'image';
                    $imageurl = $raw_image;
                    $new_post = array(
                          'ID' => '',
                          'post_type' => 'tf_slider',
                          'post_author' => '1', 
                          'post_content' => '',
                          'post_title' => $post_title,
                          'post_status' => 'publish',
                        );

                    // Create New Slide
                    $post_id = wp_insert_post($new_post);

                    // Update Meta Data
                    $order_id = intval($post_id)*100;
                    update_post_meta( $post_id,'_tfslider_type', $slidertype);
                    update_post_meta( $post_id,'_tfslider_order', $order_id);
                    update_post_meta( $post_id,'tfslider_image', $imageurl);
                    }
                $c++;
                endwhile;
                update_option('tf_sliderconverion','true');
                }
     }
?>