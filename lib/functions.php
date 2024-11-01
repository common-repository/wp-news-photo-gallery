<?php
function register_wpnpg_page() {
	add_submenu_page( 
	'edit.php?post_type=wpnpg', 
	'Gallery Settings', 
	'Gallery Settings', 
	'manage_options', 
	'wpnpg-slider-page', 
	'wpnpg_admin_settings' ); 
}
add_action('admin_menu', 'register_wpnpg_page');

function wpnpg_admin_settings() {
	
	echo '<div class="wpnpg_warp">';
		echo '<h1>WP News Photo Gallery</h1>';
?>

<div id="wpnpg_left">
  <form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <div class="inside">
      <h3><?php echo esc_attr(__('Insert your settings')); ?></h3>
      <table class="form-table">
        <tr>
          <th><label for="wpnpg_gallery_title_display"><?php echo esc_attr(__('Display/Hide Gallery Title')); ?></label></th>
          <td><select name="wpnpg_gallery_title_display" id="wpnpg_gallery_title_display">
              <option value="true" <?php if( get_option('wpnpg_gallery_title_display') == 'true'){ echo 'selected="selected"'; } ?>>Display</option>
              <option value="false" <?php if( get_option('wpnpg_gallery_title_display') == 'false'){ echo 'selected="selected"'; } ?>>Hide</option>
            </select></td>
        </tr>
        <tr>
          <th><label for="wpnpg_gallery_title"><?php echo esc_attr(__('Gallery Title')); ?></label></th>
          <td><input type="text" name="wpnpg_gallery_title" value="<?php $wpnpg_gallery_title = get_option('wpnpg_gallery_title'); if(!empty($wpnpg_gallery_title)) {echo $wpnpg_gallery_title;} else {echo "Photo Gallery";}?>"></td>
        </tr>
        <tr>
          <th><label for="wpnpg_auto_play"><?php echo esc_attr(__('Auto Play')); ?></label></th>
          <td><select name="wpnpg_auto_play" id="wpnpg_auto_play">
              <option value="true" <?php if( get_option('wpnpg_auto_play') == 'true'){ echo 'selected="selected"'; } ?>>Yes</option>
              <option value="false" <?php if( get_option('wpnpg_auto_play') == 'false'){ echo 'selected="selected"'; } ?>>No</option>
            </select></td>
        </tr>
        <tr>
          <th><label for="wpnpg_animation_type"><?php echo esc_attr(__('Animation Style')); ?></label></th>
          <td><select name="wpnpg_animation_type" id="wpnpg_animation_type">
              <option value="slide" <?php if( get_option('wpnpg_animation_type') == 'slide'){ echo 'selected="selected"'; } ?>>Slide</option>
              <option value="fade" <?php if( get_option('wpnpg_animation_type') == 'fade'){ echo 'selected="selected"'; } ?>>Fade</option>
            </select></td>
        </tr>
        <tr>
          <th><label for="wpnpg_control_nav"><?php echo esc_attr(__('Control Navigation')); ?></label></th>
          <td><select name="wpnpg_control_nav" id="wpnpg_control_nav">
              <option value="true" <?php if( get_option('wpnpg_control_nav') == 'true'){ echo 'selected="selected"'; } ?>>Yes</option>
              <option value="false" <?php if( get_option('wpnpg_control_nav') == 'false'){ echo 'selected="selected"'; } ?>>No</option>
            </select></td>
        </tr>
        <tr>
          <th><label for="wpnpg_pause_hover"><?php echo esc_attr(__('Pause On Hover')); ?></label></th>
          <td><select name="wpnpg_pause_hover" id="wpnpg_pause_hover">
              <option value="true" <?php if( get_option('wpnpg_pause_hover') == 'true'){ echo 'selected="selected"'; } ?>>Yes</option>
              <option value="false" <?php if( get_option('wpnpg_pause_hover') == 'false'){ echo 'selected="selected"'; } ?>>No</option>
            </select></td>
        </tr>
        <tr>
          <th><label for="wpnpg_slide_loop"><?php echo esc_attr(__('Auto Loop')); ?></label></th>
          <td><select name="wpnpg_slide_loop" id="wpnpg_slide_loop">
              <option value="true" <?php if( get_option('wpnpg_slide_loop') == 'true'){ echo 'selected="selected"'; } ?>>Yes</option>
              <option value="false" <?php if( get_option('wpnpg_slide_loop') == 'false'){ echo 'selected="selected"'; } ?>>No</option>
            </select></td>
        </tr>
        <tr>
          <th><label for="wpnpg_thumbnail_width"><?php echo esc_attr(__('Thumbnail Size')); ?></label></th>
          <td><input type="text" name="wpnpg_thumbnail_width" value="<?php $wpnpg_thumbnail_width = get_option('wpnpg_thumbnail_width'); if(!empty($wpnpg_thumbnail_width)) {echo $wpnpg_thumbnail_width;} else {echo "210";}?>"></td>
        </tr>
        <tr>
          <th><label for="wpnpg_thumbnail_margin"><?php echo esc_attr(__('Thumbnail Item Margin')); ?></label></th>
          <td><input type="text" name="wpnpg_thumbnail_margin" value="<?php $wpnpg_thumbnail_margin = get_option('wpnpg_thumbnail_margin'); if(!empty($wpnpg_thumbnail_margin)) {echo $wpnpg_thumbnail_margin;} else {echo "5";}?>"></td>
        </tr>
      </table>
      <input type="hidden" name="action" value="update" />
      <input type="hidden" name="page_options" value="wpnpg_gallery_title_display, wpnpg_gallery_title, wpnpg_border_color, wpnpg_auto_play, wpnpg_animation_type, wpnpg_control_nav, wpnpg_pause_hover, wpnpg_slide_loop, wpnpg_thumbnail_width, wpnpg_thumbnail_margin" />
      <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" class="button button-primary" />
      </p>
    </div>
  </form>
</div>
<div id="wpnpg_right">
  <div class="wpnpg_widget">
    <h3>
      <?php _e('Donate and support the development.','nht') ?>
    </h3>
    <p>
      <?php _e('With your help I can make Simple Fields even better! $5, $10, $100 – any amount is fine! :)','nht') ?>
    </p>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="82C6LTLMFLUFW">
      <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
      <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
  <div class="wpnpg_widget">
    <h3><?php echo esc_attr(__('About the Plugin')); ?></h3>
    <p>You can make my day by submitting a positive review on <a href="https://wordpress.org/support/view/plugin-reviews/wp-news-photo-gallery" target="_blank"><strong>WordPress.org!</strong> <img src="<?php bloginfo('url' ); echo"/wp-content/plugins/wp-news-photo-gallery/img/review.png"; ?>" alt="review" class="review"/></a></p>
    <div class="clrFix"></div>
  </div>
  <div class="wpnpg_widget">
    <div class="clrFix"></div>
    <h3>About the Author</h3>
    <p>I am a Web Developer, Expert WordPress Developer. I am regularly available for interesting freelance projects. If you ever need my help, do not hesitate to get in touch <a href="https://www.upwork.com/freelancers/~01bf79370d989b2033" target="_blank">me</a>.<br />
      <strong>Skype:</strong> cse.hasib<br />
      <strong>Email:</strong> cse.hasib@gmail.com<br />
      <strong>Web:</strong> <a href="https://www.upwork.com/freelancers/~01bf79370d989b2033">cse.hasib</a><br />
    <div class="clrFix"></div>
  </div>
</div>
<div class="clrFix"></div>
<?php		
	echo '</div>';
}
