<?php 

/**
 * Adds the OpenGraph meta tags to the head.
 * 
 */

function tf_add_og_meta_tags() {

    global $post;

    if ( is_admin() )
        return;

    // Required OG Title

    ?>

    <meta property="og:title" content="<?php the_title(); ?>" />
    <meta property="og:url" content="<?php the_permalink(); ?>" />

    <?php

    // Required OG Image

    ?>

    <meta property="og:image" content="<?php $logo = wp_get_attachment_image_src( get_option('tf_logo_id'), 'large' ); echo $logo[0]; ?>" />

    <?php

    // Slider Images

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
        $my_query = new WP_query( $args );


    while ( $my_query->have_posts() ) : $my_query->the_post();

        // - variables -
        $custom = get_post_custom( get_the_ID() );

        // - image (with fallback support)
        $meta_image = $custom["tfslider_image"][0];
        $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

        if ( $post_image[0] && strpos( $meta_image, 'http://template-' ) === false ) {
            $image = $post_image[0];
        } else {
            $image = $meta_image;
        }

        echo '<meta property="og:image" content="' . $image . '" />';

    endwhile;

   // Template specific

        if ( is_single() ) {

                ?>

                <meta property="og:type" content="article" />
                <meta property="og:description" content="<?php the_excerpt(); ?>" />

                <?php

        }

        if ( is_front_page() ) {

                ?>

                <meta property="og:type" content="website" />

                <?php


        } elseif ( !is_front_page() && is_home() ) {

        ?>

        <meta property="og:type" content="blog" />

        <?php

        } elseif ( is_page() ) {

                ?>

                <meta property="og:type" content="article" />

                <?php

    }

    ?>

    <?php

}

/*

function tf_add_og_meta_tags() {
	
	global $post;
	
	if ( is_admin() )
		return;
	
	$meta = array();
	
    $image = array( 'property' => 'og:image', 'content' => get_option( 'tf_logo' ) );
	
	//Site name
	$meta[] = array( 'property' => 'og:site_name', 'content' => get_bloginfo() );
	
	if ( is_single() ) {
		$meta[] = array( 'property' => 'og:title', 'content' => get_the_title() );
		$meta[] = array( 'property' => 'og:url', 'content' => get_permalink() );
		$meta[] = array( 'property' => 'og:description', 'content' => get_the_excerpt() );
		
		// Content Type
		if ( get_post_type() == 'post' ) {
			
			$meta[] = array( 'property' => 'og:type', 'content' => 'article' );
			
			// Post Image
			// we dont use get_post_thumbnail_id as we want to be able
			// to fall back on embadded images etc, which is done through the "post_thumbnail_html"
			// hook, so we get the html and preg_match the image src
			
			$post_thumbnail_html = get_the_post_thumbnail( $post->ID, 'width=100&height=100&crop=1' );
			
			if ( $post_thumbnail_html ) {
				
				preg_match( '/ src="( [^"]* )/', $post_thumbnail_html, $matches );
			
				if ( !empty( $matches[1] ) ) {
			
					$post_thumbnail = $matches[1];
					$meta[] = array( 'property' => 'og:image', 'content' => $post_thumbnail );
				}
			} else {
				$meta[] = $image;
			}
		} elseif ( get_post_type() == 'tf_events' ) {
			
			$meta[] = array( 'property' => 'og:type', 'content' => 'activity' );
			
			// Post Image
			// we dont use get_post_thumbnail_id as we want to be able
			// to fall back on embadded images etc, which is done through the "post_thumbnail_html"
			// hook, so we get the html and preg_match the image src
			
			$post_thumbnail_html = get_the_post_thumbnail( $post->ID, 'width=100&height=100&crop=1' );
			
			if ( $post_thumbnail_html ) {
				
				preg_match( '/ src="( [^"]* )/', $post_thumbnail_html, $matches );
			
				if ( !empty( $matches[1] ) ) {
			
					$post_thumbnail = $matches[1];
					$meta[] = array( 'property' => 'og:image', 'content' => $post_thumbnail );
				}
			} else {
				$meta[] = $image;
			}	
		
		} elseif ( get_post_type() == 'tf_foodmenu' ) {
		
		}
		
	} elseif ( is_front_page() ) {
		
		$meta[] = array( 'property' => 'og:type', 'content' => 'restaurant' );

		if ( $phone_number = get_option( 'tf_business_phone' ) ) {
			$meta[] = array( 'property' => 'og:phone_number', 'content' => $phone_number );
		}
		
		if ( $image ) { $meta[] = $image; }
		
	} elseif ( !is_front_page() && is_home() ) {
		$meta[] = array( 'property' => 'og:type', 'content' => 'blog' );
		$meta[] = $image;
	}

	foreach( $meta as $meta_item ) : 
		if ( $meta_item['content'] ) :?>
			<meta property="<?php echo $meta_item['property'] ?>" content="<?php echo $meta_item['content'] ?>" />
		<?php endif;	
	endforeach;

}

*/

add_action( 'wp_head', 'tf_add_og_meta_tags' );