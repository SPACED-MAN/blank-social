<?php

function social_is_configured() {
  global $social_cache_lifetime, $social_cache_limit;

  if( empty($social_cache_lifetime) ||
      empty($social_cache_limit) ||
      ($social_cache_lifetime <= 0) ||
      ($social_cache_limit <= 0) ) {
    return false;
  } else {
    return true;
  }
}

function social_text_sanitize($str) {
  return filter_var($str, FILTER_SANITIZE_STRING);
}

function social_text_addlinks($str) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\)\s])?)?)@', '<a href="$0" target="_blank" title="$0">link</a>', $str);
}

function social_text_truncate_html($s, $l, $e = '&hellip;', $isHTML = true) {
  $s = trim($s);
  $e = (strlen(strip_tags($s)) > $l) ? $e : '';
  $i = 0;
  $tags = array();

  if($isHTML) {
    preg_match_all('/<[^>]+>([^<]*)/', $s, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
    foreach($m as $o) {
      if($o[0][1] - $i >= $l) {
          break;
      }
      $t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
      if($t[0] != '/') {
          $tags[] = $t;
      }
      elseif(end($tags) == substr($t, 1)) {
          array_pop($tags);
      }
      $i += $o[1][1] - $o[0][1];
    }
  }
  $output = substr($s, 0, $l = min(strlen($s), $l + $i)) . (count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '') . $e;
  return $output;
}