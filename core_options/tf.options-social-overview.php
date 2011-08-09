<?php

/*
 * TF OPTIONS: YELP
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------
// TODO Add functionality to edit existing slides.

function themeforce_social_overview_page() {
    ?>
    <div class="wrap" id="tf-options-page">
        <h3>What is Social Proof, and why you need it.</h3>
        <p>Social proof is a <strong>psychological mechanism</strong> whereby we look to others to help guide our daily decisions, i.e. music trends, clothes, etc.</p>
        <img src="<?php echo get_bloginfo('template_url').'/themeforce/assets/images/sp-example.jpg'; ?>">
    </div>
    <?php
        
}	
?>