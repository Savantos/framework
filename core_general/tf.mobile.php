<?php

// Adapted from Mike Schinkel
// http://wordpress.stackexchange.com/questions/859/show-a-wp-3-0-custom-menu-in-an-html-select-with-auto-navigation

function wp_nav_mobile($menu) {
          
  $page_menu_items = wp_get_nav_menu_items($menu,array(
    'meta_key'=>'_menu_item_object',
  ));
  $selector = array();
  if (is_array($page_menu_items) && count($page_menu_items)>0) {
    $selector[] =<<<HTML
<select id="page-selector" name="page-selector"
    onchange="location.href = document.getElementById('page-selector').value;">
HTML;
    $selector[] = '<option value="">Select a Page</option>';
    foreach($page_menu_items as $page_menu_item) {
      $link = get_page_link($page_menu_item->object_id);
      $prefix = '';
      if ($page_menu_item->menu_item_parent > 0 ) { $prefix = '- ';}
      $selector[] =<<<HTML
<option value="{$link}">{$prefix}{$page_menu_item->title}</option>
HTML;
  }
    $selector[] = '</select>';
  }
  return implode("\n",$selector);
}        
?>
