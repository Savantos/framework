<?php

/**
 * Create CTA Button
 *
 * @return mixed|Call to Action
 */
function tf_cta_button() {

    // TODO Output call to action including any tracking properties for A/B

    ?>

    <a href="" id="cta-header" class="cta"><span class="cta-icon icon-cart"></span> <span class="cta-headline">Order Online</span></a>

    <script>
        mixpanel.track_links("a#cta-header", "Click Call to Action (Header)", {'referrer': document.referrer });
    </script>

    <?php

}

?>