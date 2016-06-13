<?php
require( '../../custom/config.php' );
require( '../../global/model.php' );
require( 'model.php' );

try {
  if( !social_is_configured() ) { throw new Exception('Please check your config.php file and ensure you\'ve configured the main settings correctly.'); }
  if( !tw_user_is_configured() ) { throw new Exception('Please check your config.php file and ensure you\'ve configured the tw app and user settings correctly.'); }

  // Validate GET variables
  $social_theme   = isset($_GET['theme'])   ?   filter_var($_GET['theme'], FILTER_VALIDATE_BOOLEAN)   : false;
  $social_offset  = isset($_GET['offset'])  ?   filter_var($_GET['offset'], FILTER_VALIDATE_INT)      : 0;
  $social_limit   = (isset($_GET['limit']) && ($_GET['limit'] > 0))   ?   filter_var($_GET['limit'], FILTER_VALIDATE_INT)       : -1; // 0 or negative number for no limit

  tw_user_refresh_cache($tw_user_cache_file, $social_cache_lifetime, $social_cache_limit); // Only refreshes if the cache doesn't exist or is more than __ hours old

  if( $social_theme ) { // If we're returning a themed, HTML response
    foreach( tw_user_get_cache($social_offset, $social_limit) as $social_item_index=>$tw_user_item ) {
      // Date
      $social_item_date = strtotime($tw_user_item->created_at); // Response format example: Fri May 27 13:38:22 +0000 2016 - Reformats to 1456935411

      // Description
      $social_item_description = $tw_user_item->text;

      // Link
      $social_item_link = 'https://twitter.com/' . $tw_user_name . '/status/' . $tw_user_item->id;

      // Load template
      include($tw_user_template_file);
    }
  } else { // If we're returning JSON
    header('Content-Type: application/json');
    echo json_encode(tw_user_get_cache($social_offset, $social_limit));
  }
} catch(Exception $e) {
  echo 'Error: ' . $e->getMessage();
}