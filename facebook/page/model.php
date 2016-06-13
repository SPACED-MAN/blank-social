<?php

function fb_page_is_configured() {
  global $fb_page_cache_file, $fb_app_id, $fb_app_secret, $fb_page_id, $fb_page_template_file;

  if(file_exists('../../custom/'.$fb_page_template_file)) { // In case someone created a custom template
    $fb_page_template_file = '../../custom/'.$fb_page_template_file;
  }

  if( (strcmp($fb_app_id, '[YOUR APP ID]') == 0) ||
      (strcmp($fb_app_secret, '[YOUR APP SECRET]') == 0) ||
      (strcmp($fb_page_id, '[YOUR PAGE ID]') == 0) ||
      (strcmp($fb_app_id, '') == 0) ||
      (strcmp($fb_app_secret, '') == 0) ||
      (strcmp($fb_page_id, '') == 0) ||
      (strcmp($fb_page_cache_file, '') == 0) ||
      !file_exists($fb_page_template_file) ) {
    return false;
  } else {
    return true;
  }
}

function fb_page_refresh_cache($fb_page_cache_file, $social_cache_lifetime = 24, $social_cache_limit = 100) {
  global $fb_app_id, $fb_app_secret, $fb_page_id;

  if( !file_exists($fb_page_cache_file) || filemtime($fb_page_cache_file) < time() - ($social_cache_lifetime * 3600) ) {
    $fb_page_url_request = 'https://graph.facebook.com/'.$fb_page_id.'/feed/?&access_token='.$fb_app_id.'|'.$fb_app_secret.'&limit='.$social_cache_limit.'&fields=status_type,message,story,created_time,id';

    $fb_page_content = file_get_contents($fb_page_url_request);
    file_put_contents($fb_page_cache_file, $fb_page_content); // Save it to the cache file
  }
}

function fb_page_get_cache($social_offset = 0, $social_limit = -1) {
  global $fb_page_cache_file;

  $fb_page_json = json_decode(file_get_contents($fb_page_cache_file));
  if( !is_null($fb_page_json) ) {
    $fb_page_json = $fb_page_json->data;
    $fb_page_json = array_slice($fb_page_json, $social_offset, $social_limit);
  }

  return $fb_page_json;
}