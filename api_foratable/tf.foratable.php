<?php

/*
 * forAtable Integration
 * ---------------------------------------------
 *
 * Adds reservation button.
 *
*/

/**
 * Get forAtable API Response
 *
 * @return array|mixed|null Fresh API Response
 */
function tf_foratable_api() {

    $api_id = get_option( 'lunchgate_restaurant_id' );
    // Fallback to visible Option Value (not using lunchgate_restaurant_id as don't want users to be able to overwrite)
    if ( !$api_id ) {
        $api_id = get_option( 'tf_foratable_id' );
    }

    $api_hash = 'e6df957b54422bd88511455308c163e4';

    $api_response = wp_remote_post( "http://foratable.com//api/getUrl", array(
        body => array('lunchgate_id' => $api_id, 'mediapartner_hash' => $api_hash) )
    );

    $foratablefile = wp_remote_retrieve_body( $api_response );
    $foratable = json_decode( $foratablefile );
    var_dump($foratable);

    if ( !isset( $foratable->status ) || $foratable->status != 'ok' ) {
        return null;
    }

    return $foratable;
}

/**
 * Check forAtable API Transient
 *
 * @return array|mixed|null Transient API Response
 */
function tf_foratable_transient() {

    // - get transient -
    $json = get_transient( 'themeforce_foratable_json' );

    // - refresh transient -
    if ( !$json ) {
        $json = tf_foratable_api();
        set_transient('themeforce_foratable_json', $json, 1);
    }

    // - data -
    return $json;
}


/**
 * Returns forAtable for Desktop
 *
 * @return string DOM output
 */
function tf_foratable_desktop() {

    $foratable = tf_foratable_transient();

    if ( !$foratable ) {

        return;

    } else {

        $link = $foratable->url;

        // A/B Testing

        if ( date('j') % 2 ) { // day of month will likely be less biased then day of week, or hour of day.
            //even
        } else {
            //odd
        }

        // Arguments

        $args = array(

            "tracklinks" => false,
            "mp_target" => "a#cta-header",
            "mp_name" => "Clicked Call to Action (Main)",
            "partner" => "foratable",
            "revenue_type" => "reservations",
            "placement" => "header",
            "device" => "desktop",
            "headline" => "Tisch reservieren",
            "color" => "default"

        );


        // Display

        ?>

        <a id="cta-header" class="cta-desktop cta-<?php echo $args["color"]; ?>" href="<?php echo $link; ?>">
            <span class="cta-icon icon-event"></span> <span class="cta-headline"><?php echo $args["headline"]; ?></span>
        </a>

        <script>mixpanel.track("Viewed Page");</script>

        <?php tf_cta_mixpanel($args); ?>

        <div class="clearfix"></div>

        <?php

    }

}

if ( get_option( 'tf_foratable_enabled' ) == 'true') {

    add_action( 'tf_body_desktop_cta', 'tf_foratable_desktop', 12);

}

/**
 * Returns forAtable for Mobile
 *
 * @return string DOM output
 */
function tf_foratable_mobile() {

    $foratable = tf_foratable_transient();

    if ( !$foratable ) {

        return;

    } else {

        $link = $foratable->url;

        // Arguments

        $args = array(

            "tracklinks" => false,
            "mp_target" => "a.cta-mobile",
            "mp_name" => "Clicked Call to Action (Main)",
            "partner" => "foratable",
            "revenue_type" => "reservations",
            "placement" => "header",
            "device" => "mobile",
            "headline" => "Tisch reservieren",
            "color" => "default"

        );

        // Display

        if ( get_option( 'tf_foratable_enabled' ) == 'true') {

                ?>

                <a class="cta-mobile cta-<?php echo $args["color"]; ?>" href="<?php echo $link; ?>">
                    <span class="cta-icon icon-event"></span> <span class="cta-headline"><?php echo $args["headline"]; ?></span>
                </a>

                <div class="clearfix"></div>

                <script>mixpanel.track("Viewed Page");</script>

                <?php tf_cta_mixpanel($args); ?>

                <?php

        }

    }

}

if ( get_option( 'tf_foratable_enabled' ) == 'true') {

    add_action( 'tf_body_mobile_cta', 'tf_foratable_mobile', 12);

}

/**
 * Load ForAtable JS if active
 */
function load_foratable_js() {

    wp_enqueue_script('foratable', 'http://foratable.com/code/foratable.js', array('jquery'), TF_VERSION );

}

if ( get_option( 'tf_foratable_enabled' ) == 'true') {

    add_action( 'wp_print_scripts', 'load_foratable_js');

}