<?php
/*
 * Opendining Integration
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
function tf_opendining_desktop() {
    
    $output = '';
    
    if ( get_option( 'tf_opendining_enabled' ) == 'true') {

            $appid = trim(get_option(tf_opendining_app_id));
            $output .= '<!-- opendining (desktop) -->';
            $output .= '<script type="text/javascript">(function(){function b(){var c=document.createElement("script"),a=document.getElementsByTagName("script")[0];c.type="text/javascript";c.async=true;c.src=(("https:"==document.location.protocol)?"https":"http")+"://www.opendining.net/media/js/order-button.js?id=' . $appid . '";a.parentNode.insertBefore(c,a)}if(window.attachEvent){window.attachEvent("onload",b)}else{window.addEventListener("load",b,false)}})();</script>';
            $output .= '<!-- / opendining (desktop) -->';

        }
        
    echo $output;
    
};

add_action( 'tf_body_top', 'tf_opendining_desktop', 12);

/**
 * Returns JS Drop-in for Open Dining (fixed position button) for Mobile
 *
 * @return string DOM output
 */
function tf_opendining_mobile() {

    $output = '';

    if ( get_option( 'tf_opendining_enabled' ) == 'true') {

            $restid = trim(get_option(tf_opendining_rest_id));
            $output .= '<!-- opendining (mobile) -->';
            $output .= '<div class="opendining-mobile"><a style="color:white !important;" href="http://www.opendining.net/m/' . $restid . '">Order Online</a></div>';
            $output .= '<!-- / opendining (mobile) -->';

        }

    echo $output;

}