<?php

/*
 * Localina Integration
 * ---------------------------------------------
 *
 * This is a pretty light integration to see how visitors will use it. Similar to Yelp, the feature
 * will degrade for mobile.
 *
*/

function tf_localina_bar() {

    ob_start();

    if ( get_option('tf_localina_bar_enabled' ) == 'true') {

        $api = trim(get_option(tf_localina_api));
        $phone = trim(get_option(tf_localina_phone));
        $text = trim(get_option(tf_localina_bar_text));

        echo '<div id="localinabar">';
            echo '<div id="localinabar-center">';
            echo '<a class="localinalink" href="javascript:;" onclick="Localina.startBooking(\'' . $phone . '\', \''. $api . '\', \'de\', $(this)); return false;">' . $text . '</a>';
            echo '</div>';
        echo '</div>';

    }

    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
};

add_action('tf_body_top', 'tf_localina_bar', 12);

function load_localina_js() {

    wp_enqueue_script('localina', 'http://localina.com/code/localina.js', array('jquery'), TF_VERSION );

}

if ( get_option('tf_localina_api' ) && get_option('tf_localina_phone' ) ) {

    add_action('wp_print_scripts', 'load_localina_js');

}