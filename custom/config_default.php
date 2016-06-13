<?php

// MAIN SETTINGS
$social_cache_lifetime = 24;  // Refresh cache every 24 hours
$social_cache_limit = 50;     // Maximum number of entries stored


// FACEBOOK: APP SETTINGS (required for using Facebook feeds)
$fb_app_id = '[YOUR APP ID]';
$fb_app_secret = '[YOUR APP SECRET]';

// FACEBOOK: PAGE FEED SETTINGS
$fb_page_id = '[YOUR PAGE ID]';
$fb_page_cache_file = 'facebook-page.json';
$fb_page_template_file = 'facebook-page.tpl.php'; // Copy this file to the 'custom' directory to create your own template


// TWITTER: APP SETTINGS (required for using Twitter feeds)
$tw_app_consumer_key = '[YOUR APP CONSUMER KEY]';
$tw_app_consumer_secret = '[YOUR APP CONSUMER SECRET]';
$tw_app_token = '[YOUR APP TOKEN]';
$tw_app_token_secret = '[YOUR APP TOKEN SECRET]';

// TWITTER: USER FEED SETTINGS
$tw_user_name = '[YOUR USER NAME]';
$tw_user_cache_file = 'twitter-user.json';
$tw_user_template_file = 'twitter-user.tpl.php'; // Copy this file to the 'custom' directory to create your own template


// INSTAGRAM: APP SETTINGS (required for using Instagram feeds)
$ig_app_token = '[YOUR APP TOKEN]';

// INSTAGRAM: USER FEED SETTINGS
$ig_user_id = '[YOUR USER ID]';
$ig_user_cache_file = 'instagram-user.json';
$ig_user_template_file = 'instagram-user.tpl.php'; // Copy this file to the 'custom' directory to create your own template
