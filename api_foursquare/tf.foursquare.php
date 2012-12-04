<?php

/**
 * Retrieves the foursquare response.
 *
 * @return object - JSON
 */
function tf_foursquare_api() {

	// - setup -

    if ( get_option('tf_fsquare_client_id') != '' ) {
        $client_id = get_option( 'tf_fsquare_client_id' );
    } else {
        $client_id = 'HQ0CMMQ4KQRUFNN5XF53HK0DAV2YEZYBH2H14ZUGLOQW3QE2';
    }

    if ( get_option('tf_fsquare_client_secret') != '' ) {
        $client_secret = get_option( 'tf_fsquare_client_secret' );
    } else {
        $client_secret = 'N0KTGPFJYZQ5LE1TPUA3YAE2NC0I1ANRESC1QJQWPZXLXS3W';
    }

	$fs_venue = get_option( 'tf_fsquare_venue_id' );
	$fs_id = '?client_id=' . $client_id;
	$fs_secret = '&client_secret=' . $client_secret;
	$fs_url = 'https://api.foursquare.com/v2/venues/' . $fs_venue . $fs_id . $fs_secret . '&v=20120101';

	// - response -

	$api_response = wp_remote_get($fs_url, array( 'timeout' => 30, '_wp_http_get_object' => false, 'sslverify' => false  ));

	if ( is_wp_error( $api_response ) )
		return $api_response;

	$json = wp_remote_retrieve_body( $api_response );

	$response = json_decode( $json );

	// - error checking -
	if ( !isset( $response->meta->code ) || $response->meta->code != 200 )

		return new WP_Error( 'fs-not-200', 'Foursquare did not return a valid code, API is possibly down (returned: ' . $response->meta->code . ' )' );

	return $response;
}

/**
 * Gets the foursquare data transient (lasts 180 seconds).
 *
 * @return object
 */

function tf_foursquare_transient() {

	// - get transient -
	$json = get_transient( 'tf_foursquare_json' );

	// - refresh transient -
	if ( !$json ) {
		$json = tf_foursquare_api();

		if ( !empty( $json ) && !is_wp_error( $json ) )
			set_transient( 'tf_foursquare_json', $json, 180 );
	}
	return $json;

}

/*
 * Delete & Update the Transient upon settings update.
 */
function tf_delete_foursquare_transient_on_update_option() {

	delete_transient( 'tf_foursquare_json' );
}

add_action( 'update_option_tf_fsquare_venue_id', 'tf_delete_foursquare_transient_on_update_option' );
add_action( 'update_option_tf_fsquare_client_id', 'tf_delete_foursquare_transient_on_update_option' );
add_action( 'update_option_tf_fsquare_client_secret', 'tf_delete_foursquare_transient_on_update_option' );

/**
 * Display Foursquare Bar
 *  - Follows Foursquare Display Requirements
 *  - Schema enhanced now ( Thing > Intangible > Rating > AggregateRating )
 *
 * @return mixed DOM Output
 */
function tf_foursquare_bar() {

    if ( get_option('tf_foursquare_enabled' ) == 'true') {

        $foursquare = tf_foursquare_transient();

        if ( !$foursquare ) {

            return;

        } else {

            // Shows Response Code for Debugging (as HTML Comment)

            ?>

        <!-- foursquare bar -->

        <div id="foursquarebar">
            <div id="foursquarecontent" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                <div class="foursquareimg">
                    <a href="http://www.foursquare.com">
                        <img src ="<?php echo TF_URL . '/assets/images/foursquare_logo_50x25.png'; ?>" alt="Foursquare">
                    </a>
                </div>
                <div class="foursquaretext"><?php _e('users have rated our establishment', 'themeforce'); ?></div>
                <a href="<?php echo $foursquare->businesses[0]->url; ?>">
                    <div class="foursquareimg" itemprop="ratingValue"><img src="<?php echo $foursquare->businesses[0]->rating_img_url;  ?>" alt="<?php echo $foursquare->businesses[0]->avg_rating; ?>" style="padding-top:7px;" /><meta itemprop="bestRating" content="5" /></div>
                </a>
                <div class="foursquaretext"><?php _e('through', 'themeforce'); ?></div>
                <div class="foursquaretext">
                    <a href="<?php echo $foursquare->businesses[0]->url; ?>" target="_blank">
                        <span itemprop="ratingCount"><?php echo $foursquare->businesses[0]->review_count; ?></span>&nbsp;<?php _e( 'Reviews', 'themeforce' ); ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- / foursquare bar -->

        <?php

        }
    }

};

add_action('tf_body_top', 'tf_foursquare_bar', 12);