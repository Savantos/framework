<?php
/*
 * Localina Integration
 * ---------------------------------------------
 *
 * This is a pretty light integration to see how visitors will use it. Similar to Yelp, the feature
 * will degrade for mobile (not self-hosting for now, though code here: github.com/opendining/opendining-mobile)
 *
*/


/**
 * Returns JS Drop-in for Open Dining (fixed position button) for Desktop
 *
 * @return string DOM output
 */
function tf_foratable_desktop() {

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

        $id = trim(get_option(tf_foratable_id));

        // Trigger Localina Fancybox after MixPanel hit

        $args['eval'] = "ForAtable.startBooking( '" . $phone . "', '" . $api . "', 'de' );";

        // Display

        ?>

        <a id="cta-header" class="cta-desktop cta-<?php echo $args["color"]; ?>" href="http://foratable.com/book/restaurant/<?php echo 'id'; ?>">
            <span class="cta-icon icon-event"></span> <span class="cta-headline"><?php echo $args["headline"]; ?></span>
        </a>

        <script>mixpanel.track("Viewed Page");</script>

        <?php tf_cta_mixpanel($args); ?>

        <div class="clearfix"></div>

        <?php

}

if ( get_option( 'tf_foratable_enabled' ) == 'true') {

    add_action( 'tf_body_desktop_cta', 'tf_foratable_desktop', 12);

}

/**
 * Returns JS Drop-in for Open Dining (fixed position button) for Mobile
 *
 * @return string DOM output
 */
function tf_foratable_mobile() {

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

    $api = trim(get_option(tf_foratable_id));

    // Trigger Localine Fancybox after MixPanel hit

    $args['eval'] = "ForAtable.startBooking( '" . $phone . "', '" . $api . "', 'de' );";

    // Display

    if ( get_option( 'tf_foratable_enabled' ) == 'true') {

            ?>

            <a class="cta-mobile cta-<?php echo $args["color"]; ?>" href="http://foratable.com/book/restaurant/<?php echo 'id'; ?>">
                <span class="cta-icon icon-event"></span> <span class="cta-headline"><?php echo $args["headline"]; ?></span>
            </a>

            <div class="clearfix"></div>

            <script>mixpanel.track("Viewed Page");</script>

            <?php tf_cta_mixpanel($args); ?>

            <?php

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