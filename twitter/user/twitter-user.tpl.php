<div class="social_item social_item_<?php print $social_item_index; ?> social_item_twitter_user social_item_twitter_user_<?php print $social_item_index; ?>">
  <div class="social_item_date">
    <?php print date('M d', $social_item_date); ?>
  </div>
  <div class="social_item_description">
    <?php print social_text_truncate_html(social_text_sanitize($social_item_description), 100); ?>
  </div>
  <a class="social_item_link" href="<?php print $social_item_link; ?>" target="_blank">link</a>
</div>