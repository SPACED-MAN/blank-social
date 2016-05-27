<?php

function ig_user_is_configured() {
  global $ig_app_token, $ig_user_id, $ig_user_cache_file, $ig_user_template_file;

  if(file_exists('../../custom/'.$ig_user_template_file)) { // In case someone created a custom template
    $ig_user_template_file = '../../custom/'.$ig_user_template_file;
  }

  if( (strcmp($ig_app_token, '[YOUR APP TOKEN]') == 0) ||
      (strcmp($ig_user_id, '[YOUR USER ID]') == 0) ||
      (strcmp($ig_app_token, '') == 0) ||
      (strcmp($ig_user_id, '') == 0) ||
      (strcmp($ig_user_cache_file, '') == 0) ||
      !file_exists($ig_user_template_file) ) {
    return false;
  } else {
    return true;
  }
}

function ig_user_refresh_cache($ig_user_cache_file, $social_cache_lifetime = 24, $social_cache_limit = 100) {
  global $ig_app_token, $ig_user_id;

  if( !file_exists($ig_user_cache_file) && filemtime($ig_user_cache_file) < time() - ($social_cache_lifetime * 3600) ) {

    $ig_ch = curl_init();
    curl_setopt($ig_ch, CURLOPT_URL, 'https://api.instagram.com/v1/users/' . $ig_user_id . '/media/recent/?access_token=' . $ig_app_token);
    curl_setopt($ig_ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ig_ch, CURLOPT_TIMEOUT, 20);
    $ig_user_content = curl_exec($ig_ch);
    curl_close($ig_ch);

    file_put_contents($ig_user_cache_file, $ig_user_content); // Save it to the cache file
  }
}

function ig_user_get_cache($social_offset = 0, $social_limit = -1) {
  global $ig_user_cache_file;

  $ig_user_json = json_decode(file_get_contents($ig_user_cache_file));
  array_shift(array_values($ig_user_json))->data; // Removes pagination on JSON response, limits response to entry data
  $ig_user_json = $ig_user_json->data;
  $ig_user_json = array_slice($ig_user_json, $social_offset, $social_limit);

  return $ig_user_json;
}