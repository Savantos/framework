<?php
/*
 * Localina Integration
 * ---------------------------------------------
 *
 * This is a pretty light integration to see how visitors will use it. Similar to Yelp, the feature
 * will degrade for mobile.
 *
*/

/**
 * Creates Localina Bar at the top
 *
 * @return string DOM output
 */
function tf_localina_bar() {

    ob_start();

    if ( get_option('tf_localina_bar_enabled' ) == 'true') {

        $api = trim(get_option(tf_localina_api));
        $phone = trim(get_option(tf_localina_phone));
        $text = trim(get_option(tf_localina_bar_text));

        echo '<div id="localinabar">';

            echo '<div id="localinabar-center">'; ?>
            <a class="localinalink" href="javascript:;" onclick="TFOpenLocalinaBookingForm()"><?php echo $text; ?></a>
            <?php
            echo '</div>';

        echo '</div>';

    }

    $output = ob_get_contents();
    ob_end_clean();
    echo $output;

};

add_action('tf_body_top', 'tf_localina_bar', 12);

/**
 * Enqueues Localina JS if API & Phone field are populated
 */
function load_localina_js() {

    wp_enqueue_script('localina', 'http://localina.com/code/localina.js', array('jquery'), TF_VERSION );

}

if ( get_option('tf_localina_api' ) && get_option('tf_localina_phone' ) ) {

    add_action('wp_print_scripts', 'load_localina_js');

}

add_action( 'wp_footer', function() {
    ?>

<script>
    var $ = jQuery;

    function TFOpenLocalinaBookingForm() {

        jQuery( document).ready( function ($) {

            Localina.startBooking( '0041435348277', '81002020120326cd7f51405c2b60d77db182ab1adc5500', 'de' );
        } );

        return false;
    }
</script>

<?php

} );