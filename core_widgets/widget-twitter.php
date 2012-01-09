<?php
/*
Plugin Name: Twitter Widget
Description: Adds a sidebar widget to display Twitter updates. Adapted and upgraded from Sean Spalding's Twitter Widget, for use with Theme Force
Version: 1.0
Author: ThemeForce
Author URI: http://theme-force.com
License: GPL

*/

class TF_Twitter_Widget extends WP_Widget {

	
	function __construct() {

		$widget_ops = array('classname' => 'tf_twitter_widget', 'description' => 'This widget is used to show your recent Twitter activity using your Twitter account');
		$control_ops = null;
		parent::__construct('tf_twitter_widget', __('Twitter - Display Feed'), $widget_ops, $control_ops);

	}


	//Widget output on front end
	function widget( $args, $instance ) {
		
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

	//The widget form seen in 'Widgets' screen
	function form( $instance ) {
		
		$instance = wp_parse_args( (array) $instance, array( 'account' => 'themeforce', 'title' => 'Twitter Updates', 'show' => 5 ) );
		
		$account = strip_tags( $instance['account'] );
		$title = strip_tags( $instance['title'] );
		$show = strip_tags( $instance['show'] );

		// The form fields
		?>
		<p>
				<label for="Twitter-account"><?php echo __('Twitter Account:'); ?>
				
				<input style="width: 200px;" id="<?php echo $this->get_field_id('account'); ?>" name="<?php echo $this->get_field_name('account'); ?>" type="text" value="<?php echo $account; ?>" />
				
				</label></p>
		
		<p>
				<label for="Twitter-title"><?php echo __('Widget Title:'); ?>
				
				<input style="width: 200px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
				
				</label></p>
		
		<p>
				<label for="Twitter-show"><?php echo __('Display Tweets:'); ?>
				
				<select style="width: 200px;" id="<?php echo $this->get_field_id('show'); ?>" name="<?php echo $this->get_field_name('show'); ?>" type="text">
					
					<?php for( $i=1; $i<=10; $i++ ): ?>
					
						<option value="<?php echo $i?>" <?php selected( (int) $show, $i ); ?>><?php echo $i; ?></option>
					
					<?php endfor; ?>
				
				</select>
				
				</label></p>
				
		<input type="hidden" id="Twitter-submit" name="Twitter-submit" value="1" />
		<?php

	}
}

/* register widget. */
function tf_register_twitter_widget() {
	register_widget( 'TF_Twitter_Widget' );
}

/* Add  function to the widgets_init hook. */
add_action( 'widgets_init', 'tf_register_twitter_widget' );
