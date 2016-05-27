<?php
require( '../../custom/config.php' );
require( '../../global/model.php' );
require( 'model.php' );

try {
  if( !social_is_configured() ) { throw new Exception('Please check your config.php file and ensure you\'ve configured the main settings correctly.'); }
  if( !fb_page_is_configured() ) { throw new Exception('Please check your config.php file and ensure you\'ve configured the fb app and user settings correctly.'); }

  // Validate GET variables
  $social_theme   = isset($_GET['theme'])   ?   filter_var($_GET['theme'], FILTER_VALIDATE_BOOLEAN)   : false;
  $social_offset  = isset($_GET['offset'])  ?   filter_var($_GET['offset'], FILTER_VALIDATE_INT)      : 0;
  $social_limit   = (isset($_GET['limit']) && ($_GET['limit'] > 0))   ?   filter_var($_GET['limit'], FILTER_VALIDATE_INT)       : -1; // 0 or negative number for no limit

  fb_page_refresh_cache($fb_page_cache_file, $social_cache_lifetime, $social_cache_limit); // Only refreshes if the cache doesn't exist or is more than __ hours old

  if( $social_theme ) { // If we're returning a themed, HTML response
    foreach( fb_page_get_cache($social_offset, $social_limit) as $social_item_index=>$fb_page_item ) {
      // Date
      $social_item_date = strtotime($fb_page_item->created_time); // Response format example: 2015-11-12T16:50:42+0000 - Reformats to 1456935411

      // Description
      if(isset($fb_page_item->message)) {
        $social_item_description = $fb_page_item->message;
      } else if(isset($fb_page_item->story)) {
        $social_item_description = $fb_page_item->story;
      }

      // Link
      $social_item_link = 'http://facebook.com/' . str_replace('_', '/posts/', $fb_page_item->id); // Formats FB JSON to appropriate URL to post

      // Load template
      include($fb_page_template_file);
    }
  } else { // If we're returning JSON
    header('Content-Type: application/json');
    echo json_encode(fb_page_get_cache($social_offset, $social_limit));
  }
} catch(Exception $e) {
  echo 'Error: ' . $e->getMessage();
}