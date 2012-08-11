<?php

/**
 * Create CTA Button
 *
 * This will be quite an important revenue-component going forward and as such needs
 * to be flexible with regards to different partners, styles and possibly layout.
 *
 * @return mixed|Call to Action
 */
function tf_cta_button() {

    // Get Options

        /*
        Each partner needs the following data:
            - partner slug*
            - partner type*
            - partner desktop URL structure*
            - partner mobile URL structure
            - partner headline*
            - partner subtitle
            - partner credit (i.e. powered by, etc. / display requirements)
        */


    // A/B Test (not active at the moment, just ideas)

        if ( date('j') % 2 ) { // day of month will likely be less biased then day of week, or hour of day.
            //even
        } else {
            //odd
        }

    // DOM Output

    ?>

    <a href="" id="cta-header" class="cta">
        <span class="cta-icon icon-cart"></span> <span class="cta-headline">Order Online</span>
    </a>

    <script>

        mixpanel.track_links("a#cta-header", "Clicked Call to Action (Header)", {
            'revenue_type' : '', // 'reservation' or 'onlineordering'
            'partner' : '', // name of partner
            'button_variant' : '', // 'default' or others
            'credit' : '' // true or false, does partner branding help?
        });

    </script>

    <?php

}

?>