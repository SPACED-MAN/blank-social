<?php
require( '../../custom/config.php' );
require( '../../global/model.php' );
require( 'model.php' );

try {
  if( !social_is_configured() ) { throw new Exception('Please check your config.php file and ensure you\'ve configured the main settings correctly.'); }
  if( !ig_user_is_configured() ) { throw new Exception('Please check your config.php file and ensure you\'ve configured the ig app and user settings correctly.'); }

  // Validate GET variables
  $social_theme   = isset($_GET['theme'])   ?   filter_var($_GET['theme'], FILTER_VALIDATE_BOOLEAN)   : false;
  $social_offset  = isset($_GET['offset'])  ?   filter_var($_GET['offset'], FILTER_VALIDATE_INT)      : 0;
  $social_limit   = (isset($_GET['limit']) && ($_GET['limit'] > 0))   ?   filter_var($_GET['limit'], FILTER_VALIDATE_INT)       : -1; // 0 or negative number for no limit

  ig_user_refresh_cache($ig_user_cache_file, $social_cache_lifetime, $social_cache_limit); // Only refreshes if the cache doesn't exist or is more than __ hours old

  if( $social_theme ) { // If we're returning a themed, HTML response
    foreach( ig_user_get_cache($social_offset, $social_limit) as $social_item_index=>$ig_user_item ) {
      // Date
      $social_item_date = $ig_user_item->created_time;

      // Image URL
      $social_item_image_url = $ig_user_item->images->standard_resolution->url;

      // Link
      $social_item_link = $ig_user_item->link;

      // Load template
      include($ig_user_template_file);
    }
  } else { // If we're returning JSON
    header('Content-Type: application/json');
    echo json_encode(ig_user_get_cache($social_offset, $social_limit));
  }
} catch(Exception $e) {
  echo 'Error: ' . $e->getMessage();
}