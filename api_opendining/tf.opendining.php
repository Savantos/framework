<?php

/*
 * Opendining Integration
 * ---------------------------------------------
 *
 * This is a pretty light integration to see how visitors will use it. Similar to Yelp, the feature
 * will degrade for mobile (not self-hosting for now, though code here: github.com/opendining/opendining-mobile)
 *
 *
 *
*/

function tf_opendining_desktop() {
    
    $output = '';
    
    // if ( get_option('tf_opendining_enabled' ) == 'true') {
            // $opendining = trim(get_option(tf_opendining_id));
            $opendining = '4d278f47758d88fd32010000';
            $output .= '<!-- opendining (desktop) -->';
            $output .= '<script type="text/javascript">(function(){function b(){var c=document.createElement("script"),a=document.getElementsByTagName("script")[0];c.type="text/javascript";c.async=true;c.src=(("https:"==document.location.protocol)?"https":"http")+"://www.opendining.net/media/js/order-button.js?id=' . $opendining . '";a.parentNode.insertBefore(c,a)}if(window.attachEvent){window.attachEvent("onload",b)}else{window.addEventListener("load",b,false)}})();</script>';
            $output .= '<!-- / opendining (desktop) -->';
        /*} else {
            $output = '<!-- opendining (desktop) disabled -->';
        }*/
        
    echo $output;
    
};


add_action('tf_body_top', 'tf_opendining_desktop', 12);
    
function tf_opendining_mobile() {

    $output = '';

    // if ( get_option('tf_opendining_enabled' ) == 'true') {
            // $opendining = trim(get_option(tf_opendining_id));
            $opendining = '4d278f47758d88fd32010000';
            $output .= '<!-- opendining (mobile) -->';
            $output .= '<div class="opendining-mobile"><a class="opendining" href="http://www.opendining.net/m/' . $opendining . '">Order Online</a></div>';
            $output .= '<!-- / opendining (mobile) -->';
    /*} else {
            $output = '<!-- opendining (mobile) disabled -->';
    }*/

    echo $output;

}
