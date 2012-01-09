<?php
/*
Plugin Name: Twitter Widget
Description: Adds a sidebar widget to display Twitter updates. Adapted from Sean Spalding's Twitter Widget, for use with Theme Force
Version: 1.0
Author: ThemeForce
Author URI: http://theme-force.com
License: GPL

*/

function tf_twitter_widget_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;

	function tf_twitter_widget($args) {

		// "$args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys." - These are set up by the theme
		extract($args);

		// These are our own options
		$options = get_option('tf_twitter_widget');
		$account = $options['account'];  // Your Twitter account name
		$title = $options['title'];  // Title in sidebar for widget
		$show = $options['show'];  // # of Updates to show

        // Output
		echo $before_widget ;

		// start
		echo '<div id="twitter_div">'
              .$before_title.$title.$after_title;
		echo '<ul id="twitter_update_list"></ul></div>
		      <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>';
		echo '<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/'.$account.'.json?callback=twitterCallback2&amp;count='.$show.'"></script>';


		// echo widget closing tag
		echo $after_widget;
	}

	// Settings form
	function tf_twitter_widget_admin() {

		// Get options
		$options = get_option('tf_twitter_widget');
		// options exist? if not set defaults
		if ( !is_array($options) )
			$options = array('account'=>'themeforce', 'title'=>'Twitter Updates', 'show'=>'5');

        // form posted?
		if ( $_POST['Twitter-submit'] ) {

			// Remember to sanitize and format use input appropriately.
			$options['account'] = strip_tags(stripslashes($_POST['Twitter-account']));
			$options['title'] = strip_tags(stripslashes($_POST['Twitter-title']));
			$options['show'] = strip_tags(stripslashes($_POST['Twitter-show']));
			update_option('tf_twitter_widget', $options);
		}

		// Get options for form fields to show
		$account = htmlspecialchars($options['account'], ENT_QUOTES);
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$show = htmlspecialchars($options['show'], ENT_QUOTES);

		// The form fields
		?>
		<p style="text-align:right;">
				<label for="Twitter-account"><?php echo __('Twitter Account:'); ?>
				<input style="width: 200px;" id="Twitter-account" name="Twitter-account" type="text" value="<?php echo $account; ?>" />
				</label></p>
		
		<p style="text-align:right;">
				<label for="Twitter-title"><?php echo __('Widget Title:'); ?>
				<input style="width: 200px;" id="Twitter-title" name="Twitter-title" type="text" value="<?php echo $title; ?>" />
				</label></p>
		
		<p style="text-align:right;">
				<label for="Twitter-show"><?php echo __('Display Posts:'); ?>
				
				<select style="width: 200px;" id="Twitter-show" name="Twitter-show" type="text">
					
					<?php for( $i=1; $i<=10; $i++ ): ?>
					
						<option value="<?php echo $i?>" <?php selected( (int) $show, $i ); ?>"><?php echo $i; ?></option>
					
					<?php endfor; ?>
				
				</select>
				
				</label></p>
				
		<input type="hidden" id="Twitter-submit" name="Twitter-submit" value="1" />
	
	<?php 	
	}
	

	// Register widget for use
	register_sidebar_widget(array('Twitter', 'widgets'), 'tf_twitter_widget');

	// Register settings for use, 300x200 pixel form
	register_widget_control(array('Twitter', 'widgets'), 'tf_twitter_widget_admin', 300, 200);
}

// Run code and init
add_action('widgets_init', 'tf_twitter_widget_init');

?>
