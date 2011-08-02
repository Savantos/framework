<?php

/*
 * TF OPTIONS: BUSINESS
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Register Menu Pages
// -----------------------------------------

function themeforce_business_options_addmenu() {
    // TODO Need to amend capability for basic view of hosted
    add_menu_page( 'Dummy Header', 'Your Business', 'manage_options', 'themeforce_options','', get_bloginfo('template_url').'/themeforce/assets/images/general_16.png', 25); // $function, $icon_url, $position 
    add_submenu_page('themeforce_options', 'Your Business Location', 'Location', 'manage_options', 'themeforce_location', 'themeforce_location_page');
}
add_action('admin_menu','themeforce_business_options_addmenu');

// Load jQuery & relevant CSS
// -----------------------------------------

// js
function themeforce_business_options_scripts() {
    wp_enqueue_script( 'tfoptions', TF_URL . '/assets/js/themeforce-options.js', array('jquery'));
    wp_enqueue_script( 'iphone-checkbox', TF_URL . '/assets/js/jquery.iphone-style-checkboxes.js', array('jquery'));
}

add_action( 'admin_print_scripts', 'themeforce_business_options_scripts' );

// css
function themeforce_business_options_styles() {
    wp_enqueue_style( 'tfoptions', TF_URL . '/assets/css/themeforce-options.css');
}

add_action( 'admin_print_styles', 'themeforce_business_options_styles' );

// Create Page
// -----------------------------------------
// TODO Add functionality to edit existing slides.

function themeforce_location_page() {
    ?>
    <div class="wrap" id="tf-options-page">
    <div id="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";
    $options_cuisine = array('Afghan', 'African', 'American (New)', 'American (Traditional)', 'Argentine', 'Asian Fusion', 'Barbeque', 'Basque', 'Belgian', 'Brasseries', 'Brazilian', 'Breakfast & Brunch', 'British', 'Buffets', 'Burgers', 'Burmese', 'Cafes', 'Cajun/Creole', 'Cambodian', 'Caribbean', 'Cheesesteaks', 'Chicken Wings', 'Chinese', 'Creperies', 'Cuban', 'Delis', 'Diners', 'Ethiopian', 'Fast Food', 'Filipino', 'Fish & Chips', 'Fondue', 'Food Stands', 'French', 'Gastropubs', 'German', 'Gluten-Free', 'Greek', 'Halal', 'Hawaiian', 'Himalayan/Nepalese', 'Hot Dogs', 'Hungarian', 'Indian', 'Indonesian', 'Irish', 'Italian', 'Japanese', 'Korean', 'Kosher', 'Latin American', 'Live/Raw Food', 'Malaysian', 'Mediterranean', 'Mexican', 'Middle Eastern', 'Modern European', 'Mongolian', 'Moroccan', 'Pakistani', 'Persian/Iranian', 'Peruvian', 'Pizza', 'Polish', 'Portuguese', 'Russian', 'Sandwiches', 'Scandinavian', 'Seafood', 'Singaporean', 'Soul Food', 'Soup', 'Southern', 'Spanish', 'Steakhouses', 'Sushi Bars', 'Taiwanese', 'Tapas Bars', 'Tapas/Small Plates', 'Tex-Mex', 'Thai', 'Turkish', 'Ukrainian', 'Vegan', 'Vegetarian', 'Vietnamese');
    $options_pricerange = array ('$','$$','$$$','$$$$');
    $options_yesno = array ('yes','no');
    
    // Options
    
    $options = array (
 
        array( "name" => "Business Options", "type" => "title"),

        array( "type" => "open"),   
	
	// BUSINESS
	// -----------------------------------------------------------------
	
	array( "name" => "Business Name",
                "desc" => "This is used within the Address HTML tags too, so make sure it's correct",
                "id" => $shortname."_business_name",
                "std" => "Your Business Name",
                "type" => "text"),

	array( "name" => "Description",
                "desc" => "A short description of the location.",
                "id" => $shortname."_business_description",
                "std" => "",
                "type" => "textarea"),
						
	array( 
                "name" => "Cuisine",
                "desc" => "The cuisine of the restaurant. Uses the Yelp cuisine categorization.",
                "id" => "tf_schema_cuisine",
                "std" => "",
                "type" => "select",
                "class" => "small", //mini, tiny, small
                "options" => $options_cuisine),

	array( 
                "name" => "Price Range",
                "desc" => "US Example: Price range is the approximate cost per person for a meal including one drink, tax, and tip. We're going for averages here, folks. $ = Cheap, Under $10 * $$ = Moderate, $11 - $30 * $$$ = Spendy, $31 - $60 * $$$$ = Splurge, Above $61",
                "id" => "tf_schema_pricerange",
                "std" => "",
                "type" => "select",
                "class" => "small", //mini, tiny, small
                "options" => $options_pricerange),

	array( 
                "name" => "Payment Accepted",
                "desc" => "List the types of payments you accept, separate by comma.",
                "id" => "tf_schema_paymentaccepted",
                "std" => "Cash, Credit Cards",
                "type" => "text"),	
						
	array( 
                "name" => "Accept Reservations",
                "desc" => "Do you accept reservations at all?",
                "id" => "tf_schema_reservations",
                "std" => "",
                "type" => "select",
                "class" => "small", //mini, tiny, small
                "options" => $options_yesno),					
	
	array( "name" => "Menu Currency",
                "desc" => "Please enter your currency symbol or 3-letter code, whichever looks better to you. Is used for the menu.",
                "id" => "tf_currency_symbol",
                "std" => "$",
                "type" => "text"),
	
	array( "name" => "Show currency for menu prices by default?",
                "desc" => "Otherwise you will need to set it manually by using the shortcode variable",
                "id" => "tf_menu_currency_symbol",
                "std" => "false",
                "type" => "checkbox"),
	
	array( "name" => "Use advanced sort functionality for Menu?",
                "desc" => "If you don't use the advanced sort, menu items will be sorted alphabetically. ", //See <a href='http://'>this tutorial</a>for more information
                "id" => "tf_menu_sort_key",
                "std" => "true",
                "type" => "checkbox"),
        
	array( "type" => "close"), 
 
);

    tf_display_settings($options);
    ?> 
	    <input type="submit" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
	   
    </form>

        
    </div>
    <?php
        
}	
?>