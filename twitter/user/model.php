<?php

function tw_user_is_configured() {
  global $tw_app_consumer_key, $tw_app_consumer_secret, $tw_app_token, $tw_app_token_secret, $tw_user_name, $tw_user_cache_file, $tw_user_template_file;

  if(file_exists('../../custom/'.$tw_user_template_file)) { // In case someone created a custom template
    $tw_user_template_file = '../../custom/'.$tw_user_template_file;
  }

  if( (strcmp($tw_app_consumer_key, '[YOUR APP CONSUMER KEY]') == 0) ||
      (strcmp($tw_app_consumer_secret, '[YOUR APP CONSUMER SECRET]') == 0) ||
      (strcmp($tw_app_token, '[YOUR APP TOKEN]') == 0) ||
      (strcmp($tw_app_token_secret, '[YOUR APP TOKEN SECRET]') == 0) ||
      (strcmp($tw_user_name, '[YOUR USER NAME]') == 0) ||
      (strcmp($tw_app_consumer_key, '') == 0) ||
      (strcmp($tw_app_consumer_secret, '') == 0) ||
      (strcmp($tw_app_token, '') == 0) ||
      (strcmp($tw_app_token_secret, '') == 0) ||
      (strcmp($tw_user_name, '') == 0) ||
      (strcmp($tw_user_cache_file, '') == 0) ||
      !file_exists($tw_user_template_file) ) {
    return false;
  } else {
    return true;
  }
}

function tw_user_refresh_cache($tw_user_cache_file, $social_cache_lifetime = 24, $social_cache_limit = 100) {
  global $tw_app_consumer_key, $tw_app_consumer_secret, $tw_app_token, $tw_app_token_secret, $tw_user_name;

  if( !file_exists($tw_user_cache_file) && filemtime($tw_user_cache_file) < time() - ($social_cache_lifetime * 3600) ) {

    $tw_url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

    $tw_query = array_map("rawurlencode", array(
      'screen_name' => $tw_user_name,
      'count' => $social_cache_limit
    ));

    $tw_oauth = array_map("rawurlencode", array(
      'oauth_consumer_key' => $tw_app_consumer_key,
      'oauth_token' => $tw_app_token,
      'oauth_nonce' => (string)mt_rand(),
      'oauth_timestamp' => time(),
      'oauth_signature_method' => 'HMAC-SHA1',
      'oauth_version' => '1.0'
    ));

    $tw_arr = array_merge($tw_oauth, $tw_query);

    asort($tw_arr);
    ksort($tw_arr);

    $tw_query_string = urldecode(http_build_query($tw_arr, '', '&'));
    $tw_signature = rawurlencode(base64_encode(hash_hmac('sha1', "GET&".rawurlencode($tw_url)."&".rawurlencode($tw_query_string), rawurlencode($tw_app_consumer_secret)."&".rawurlencode($tw_app_token_secret), true)));
    $tw_url = str_replace("&amp;","&", $tw_url . "?" . http_build_query($tw_query) ); //Patch by @Frewuill

    $tw_oauth['oauth_signature'] = $tw_signature;
    ksort($tw_oauth);

    function add_quotes($str) { return '"'.$str.'"'; }
    $tw_oauth = array_map("add_quotes", $tw_oauth);

    $tw_auth = "OAuth " . urldecode(http_build_query($tw_oauth, '', ', '));
    $tw_options = array( CURLOPT_HTTPHEADER => array("Authorization: $tw_auth"), CURLOPT_HEADER => false, CURLOPT_URL => $tw_url, CURLOPT_RETURNTRANSFER => true, CURLOPT_SSL_VERIFYPEER => false);

    $tw_feed = curl_init();
    curl_setopt_array($tw_feed, $tw_options);
    $tw_user_content = curl_exec($tw_feed);
    curl_close($tw_feed);

    file_put_contents($tw_user_cache_file, $tw_user_content); // Save it to the cache file
  }
}

function tw_user_get_cache($social_offset = 0, $social_limit = -1) {
  global $tw_user_cache_file;

  $tw_user_json = json_decode(file_get_contents($tw_user_cache_file));
  $tw_user_json = array_slice($tw_user_json, $social_offset, $social_limit);

  return $tw_user_json;
}