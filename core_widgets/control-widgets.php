<?php

function remove_unrequired_widgets() {

	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('widget_akismet');
	unregister_widget('WP_Nav_Menu_Widget');
}

add_action( 'admin_init', 'remove_unrequired_widgets' );