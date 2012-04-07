<?php

/*
 * TF OPTIONS: BUSINESS
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------

function themeforce_business_page() {
    ?>
    <div class="wrap tf-options-page">
    <div class="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";
    $options_cuisine = array('Afghan', 'African', 'American ( New )', 'American ( Traditional )', 'Argentine', 'Asian Fusion', 'Barbeque', 'Basque', 'Belgian', 'Brasseries', 'Brazilian', 'Breakfast & Brunch', 'British', 'Buffets', 'Burgers', 'Burmese', 'Cafes', 'Cajun/Creole', 'Cambodian', 'Caribbean', 'Cheesesteaks', 'Chicken Wings', 'Chinese', 'Creperies', 'Cuban', 'Delis', 'Diners', 'Ethiopian', 'Fast Food', 'Filipino', 'Fish & Chips', 'Fondue', 'Food Stands', 'French', 'Gastropubs', 'German', 'Gluten-Free', 'Greek', 'Halal', 'Hawaiian', 'Himalayan/Nepalese', 'Hot Dogs', 'Hungarian', 'Indian', 'Indonesian', 'Irish', 'Italian', 'Japanese', 'Korean', 'Kosher', 'Latin American', 'Live/Raw Food', 'Malaysian', 'Mediterranean', 'Mexican', 'Middle Eastern', 'Modern European', 'Mongolian', 'Moroccan', 'Pakistani', 'Persian/Iranian', 'Peruvian', 'Pizza', 'Polish', 'Portuguese', 'Russian', 'Sandwiches', 'Scandinavian', 'Seafood', 'Singaporean', 'Soul Food', 'Soup', 'Southern', 'Spanish', 'Steakhouses', 'Sushi Bars', 'Taiwanese', 'Tapas Bars', 'Tapas/Small Plates', 'Tex-Mex', 'Thai', 'Turkish', 'Ukrainian', 'Vegan', 'Vegetarian', 'Vietnamese');
    $options_pricerange = array ( '$', '$$', '$$$', '$$$$' );
    $options_yesno = array ( __('yes', 'themeforce'), __('no', 'themeforce') );
	
    // Options
    
    $options = array (
 
        array( 'name' => __('Business Options', 'themeforce'), 'type' => 'title'),

        array( 'type' => 'open'),   
	
	// BUSINESS
	// -----------------------------------------------------------------
	
	array( 'name' => __('Business Name', 'themeforce'),
                'desc' => __( 'This is used within the Address HTML tags too, so make sure it\'s correct', 'themeforce'),
                'id' => $shortname.'_business_name',
                'std' => __( 'Your Business Name', 'themeforce'),
                'type' => 'text'),

	array( 'name' => __('Description', 'themeforce'),
                'desc' => __('A short description of the location.', 'themeforce'),
                'id' => $shortname.'_business_description',
                'std' => '',
                'type' => 'textarea'),
						
	array( 
                'name' => __('Cuisine', 'themeforce'),
                'desc' => __('The cuisine of the restaurant. Uses the Yelp cuisine categorization.', 'themeforce'),
                'id' => 'tf_schema_cuisine',
                'std' => '',
                'type' => 'multiple-select',
                'class' => 'small', //mini, tiny, small
                'options' => $options_cuisine),

	array( 
                'name' => __('Price Range', 'themeforce'),
                'desc' => __('US Example: Price range is the approximate cost per person for a meal including one drink, tax, and tip. We\'re going for averages here, folks. $ = Cheap, Under $10 * $$ = Moderate, $11 - $30 * $$$ = Spendy, $31 - $60 * $$$$ = Splurge, Above $61', 'themeforce'),
                'id' => 'tf_schema_pricerange',
                'std' => '',
                'type' => 'select',
                'class' => 'small', //mini, tiny, small
                'options' => $options_pricerange),

	array( 
                'name' => __('Payment Accepted', 'themeforce'),
                'desc' => __('List the types of payments you accept, separate by comma.', 'themeforce'),
                'id' => 'tf_schema_paymentaccepted',
                'std' => __('Cash, Credit Cards', 'themeforce'),
                'type' => 'text'), 	
						
	array( 
                'name' => __('Accept Reservations', 'themeforce'),
                'desc' => __('Do you accept reservations at all?', 'themeforce'),
                'id' => 'tf_schema_reservations',
                'std' => '',
                'type' => 'select',
                'class' => 'small', //mini, tiny, small
                'options' => $options_yesno), 					
	
	array( 'name' => __('Menu Currency', 'themeforce'),
                'desc' => __('Please enter your currency symbol or 3-letter code, whichever looks better to you. Is used for the menu.', 'themeforce'),
                'id' => 'tf_currency_symbol',
                'std' => __('$', 'themeforce'),
                'type' => 'text'),
	
	array( 'name' => __('Show currency for menu prices by default?', 'themeforce'),
                'desc' => __('Otherwise you will need to set it manually by using the shortcode variable', 'themeforce'),
                'id' => 'tf_menu_currency_symbol',
                'std' => 'false',
                'type' => 'checkbox'),

    array( 'name' => __('Notice in Footer', 'themeforce'),
                'desc' => __('A short text snippet to indicate any copyright or otherwise (you may also leave it blank)', 'themeforce'),
                'id' => 'tf_terminalnotice',
                'std' => '',
                'type' => 'text'),

    array( 'name' => __('Google Apps Domain Verification', 'themeforce'),
                'desc' => __('Please enter the key here if you need to verfiy a domain, i.e. <em>&lt;meta name="google-site-verification" content="<strong>THIS_IS_THE_KEY</strong>" /&gt;</em>', 'themeforce'),
                'id' => 'tf_googleapps',
                'std' => '',
                'type' => 'text'),

);

$options = apply_filters( 'tf_options_general', $options );

if ( TF_THEME == 'chowforce' ) {
				$options[]= array( 'name' => 'Tagline',
                'desc' => 'This will appear in the top right of every page. ',
                'id' => 'chowforce_biz_contactinfo',
                'std' => 'Enter your tagline here.',
                'type' => 'text');
				}
			
$options[] = array( 'type' => 'close');

    tf_display_settings( $options );
    ?> 
	 <input type="submit" class="tf-button tf-major right" name="options_submit" value=" <?php _e( 'Save Changes', 'themeforce' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        
        <div id="tf-tip">
            <h3>Why do you need all this?</h3>
            <p>The questions asked above are used to provide <strong>search engines & content aggregators</strong> with relevant information about your restaurant. These websites can then automatically generate detailed profiles about your business, generating more traffic for your website.</p>
        </div>  
        
    </div>
    <?php
        
}	
?>