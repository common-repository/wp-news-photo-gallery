<?php 
/*
Plugin Name: WP News Photo Gallery
Plugin URI: https://wordpress.org/plugins/wp-news-photo-gallery/
Description: WP News Photo Gallery is a WordPress plugin to create photo gallery on your WordPress website!  View "Photo Gallery" page for photo gallery style.
Version: 1.0.1
Author: Hasibul Islam Badsha
Author URI: https://www.bdtrips.com/
Copyright: 2019
License URI: license.txt
Text Domain: wpnpg
*/

#######################	WP News Photo Gallery ###############################

/**
	Define plugin base url
**/
define('wpnpg_gallery_path', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

/**
	Register Custom Post Type
**/
if ( ! function_exists('wpnpg_post_type') ) {
//Custom Post Type
function wpnpg_post_type() {

	$labels = array(
		'name'                  => _x( 'Photo Galleries', 'Post Type General Name', 'wpnpg' ),
		'singular_name'         => _x( 'Photo Gallery', 'Post Type Singular Name', 'wpnpg' ),
		'menu_name'             => __( 'Photo Galleries', 'wpnpg' ),
		'name_admin_bar'        => __( 'Photo Gallery', 'wpnpg' ),
		'archives'              => __( 'Item Archives', 'wpnpg' ),
		'attributes'            => __( 'Item Attributes', 'wpnpg' ),
		'parent_item_colon'     => __( 'Parent Item:', 'wpnpg' ),
		'all_items'             => __( 'All Items', 'wpnpg' ),
		'add_new_item'          => __( 'Add New Item', 'wpnpg' ),
		'add_new'               => __( 'Add New', 'wpnpg' ),
		'new_item'              => __( 'New Item', 'wpnpg' ),
		'edit_item'             => __( 'Edit Item', 'wpnpg' ),
		'update_item'           => __( 'Update Item', 'wpnpg' ),
		'view_item'             => __( 'View Item', 'wpnpg' ),
		'view_items'            => __( 'View Items', 'wpnpg' ),
		'search_items'          => __( 'Search Item', 'wpnpg' ),
		'not_found'             => __( 'Not found', 'wpnpg' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'wpnpg' ),
		'featured_image'        => __( 'Featured Image', 'wpnpg' ),
		'set_featured_image'    => __( 'Set featured image', 'wpnpg' ),
		'remove_featured_image' => __( 'Remove featured image', 'wpnpg' ),
		'use_featured_image'    => __( 'Use as featured image', 'wpnpg' ),
		'insert_into_item'      => __( 'Insert into item', 'wpnpg' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpnpg' ),
		'items_list'            => __( 'Items list', 'wpnpg' ),
		'items_list_navigation' => __( 'Items list navigation', 'wpnpg' ),
		'filter_items_list'     => __( 'Filter items list', 'wpnpg' ),
	);
	$args = array(
		'label'                 => __( 'Photo Gallery', 'wpnpg' ),
		'description'           => __( 'Photo Gallery Description', 'wpnpg' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'wpnpg', $args );

}
add_action( 'init', 'wpnpg_post_type', 0 );
}

/**
	Get all php file.
**/
foreach ( glob( plugin_dir_path( __FILE__ )."lib/*.php" ) as $php_file )
    include_once $php_file;

/**
	Register Stylesheet and Javascript. 
**/
function register_wpnpg_gallery_style(){	
	wp_register_style( 'wpnpg-style', wpnpg_gallery_path.'css/wpnpg.css' );
	wp_enqueue_style('wpnpg-style');
	
	wp_register_style( 'wpnpg-custom', wpnpg_gallery_path.'css/wpnpg-custom.css' );
	wp_enqueue_style('wpnpg-custom');
	
	wp_register_style( 'bootstrap', wpnpg_gallery_path.'css/bootstrap.css' );
	wp_enqueue_style('bootstrap');
	
	wp_register_script('flexslider-script', wpnpg_gallery_path.'js/jquery.flexslider.js', array('jquery') ); 
    wp_enqueue_script('flexslider-script');
}
add_action('init', 'register_wpnpg_gallery_style');

/**
	Register Admin Stylesheet and Javascript.
**/
function register_wpnpg_admin_style()
{
	wp_enqueue_style( 'wpnpg-admin', plugins_url('/css/wpnpg-admin.css', __FILE__) );
	wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
	wp_enqueue_script( 'cp-active', plugins_url('/js/cp-active.js', __FILE__), array('jquery'), '', true );
}
add_action( 'admin_enqueue_scripts', 'register_wpnpg_admin_style' ); 

/**
	Get post for create photo gallery.
**/
function wpnpg_photo_gallery_loop() 
{ ?>

<div class="wpnpg-container wpnpg-section">
  <div class="wpnpg-row">
    <?php if( get_option('wpnpg_gallery_title_display') == 'true'){ $wpnpg_gallery_title = get_option('wpnpg_gallery_title'); echo "<h3>".$wpnpg_gallery_title."</h3>";} ?>
    <div id="slider" class="flexslider">
      <ul class="slides">
        <?php
	$wpnpg_order = get_option('wpnpg_order');
	  $loop = new WP_Query( array(
		  'post_type' => 'wpnpg',
		  'orderby' => 'date',
		  'order' => $wpnpg_order
		)
	  );
 ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); 
	 $thumb_id = get_post_thumbnail_id();
	 $thumb_url = wp_get_attachment_image_src($thumb_id, 'full', true);
 ?>
        <li> <a href="<?php the_permalink() ?>" target="_blank"><img src="<?php echo $thumb_url[0]; ?>" /></a>
          <p class="wpnpg-caption">
            <?php the_title() ?>
          </p>
        </li>
        <?php endwhile; wp_reset_query(); ?>
      </ul>
    </div>
    <div id="carousel" class="flexslider">
      <ul class="slides">
        <?php
	$wpnpg_order = get_option('wpnpg_order');
	  $loop = new WP_Query( array(
		  'post_type' => 'wpnpg',
		  'orderby' => 'date',
		  'order' => $wpnpg_order
		)
	  );
 ?>
     <?php while ( $loop->have_posts() ) : $loop->the_post(); 
	 $thumb_id = get_post_thumbnail_id();
	 $thumb_url = wp_get_attachment_image_src($thumb_id, 'full', true);
 ?>
        <li> <img src="<?php echo $thumb_url[0]; ?>" /> </li>
        <?php endwhile; wp_reset_query(); ?>
      </ul>
    </div>
  </div>
</div>
<?php }

/**
	Slider Control Settings.
**/
function wpnpg_slide_script() { 
// get data from settings
	$wpnpg_auto_play = get_option('wpnpg_auto_play');
	$wpnpg_animation_type = get_option('wpnpg_animation_type');
	$wpnpg_control_nav = get_option('wpnpg_control_nav');
	$wpnpg_pause_hover = get_option('wpnpg_pause_hover');
	$wpnpg_slide_loop = get_option('wpnpg_slide_loop');
	$wpnpg_thumbnail_width = get_option('wpnpg_thumbnail_width');
	$wpnpg_thumbnail_margin = get_option('wpnpg_thumbnail_margin');
	

?>
<script type="text/javascript">
    jQuery(window).load(function(){
      jQuery('#carousel').flexslider({
        animation: "slide",
        controlNav: <?php echo $wpnpg_control_nav; ?>,
		pauseOnHover: <?php echo $wpnpg_pause_hover; ?>,
        animationLoop: <?php echo $wpnpg_slide_loop; ?>,
        slideshow: <?php echo $wpnpg_auto_play; ?>,
        itemWidth: <?php echo $wpnpg_thumbnail_width; ?>,
        itemMargin: <?php echo $wpnpg_thumbnail_margin; ?>,
        asNavFor: '#slider',
      });

      jQuery('#slider').flexslider({
        animation: "<?php echo $wpnpg_animation_type; ?>",
        controlNav: false,
		pauseOnHover: <?php echo $wpnpg_pause_hover; ?>,
        animationLoop: <?php echo $wpnpg_slide_loop; ?>,
        slideshow: <?php echo $wpnpg_auto_play; ?>,
        sync: "#carousel",
        start: function(slider){
          jQuery('body').removeClass('loading');
        }
      });
    });
  </script>
<?php }
add_action('wp_footer', 'wpnpg_slide_script', 100);

//include single template 
function get_wpnpg_single_template($single_template) {
 global $post;

 if ($post->post_type == 'wpnpg') {
      $single_template = dirname( __FILE__ ) . '/single-wpnpg.php';
 }
 return $single_template;
}
add_filter( "single_template", "get_wpnpg_single_template" ) ;

//include archive template 
function get_wpnpg_archive_template($archive_template) {
 global $post;

 if ($post->post_type == 'wpnpg') {
      $archive_template = dirname( __FILE__ ) . '/archive-wpnpg.php';
 }
 return $archive_template;
}
add_filter( "archive_template", "get_wpnpg_archive_template" ) ;

/**
	Add More Featured Images.
**/
//init the meta box
add_action( 'after_setup_theme', 'wpnpg_multiple_images_setup' );
function wpnpg_multiple_images_setup(){
    add_action( 'add_meta_boxes', 'wpnpg_multiple_images_meta_box' );
    add_action( 'save_post', 'wpnpg_multiple_images_meta_box_save' );
}

function wpnpg_multiple_images_meta_box(){

    //on which post types should the box appear?
    $post_types = array('wpnpg');
    foreach($post_types as $pt){
        add_meta_box('wpnpg_multiple_images_meta_box',__( 'More Featured Images', 'wpnpg'),'wpnpg_multiple_images_meta_box_func',$pt,'side','low');
    }
}

function wpnpg_multiple_images_meta_box_func($post){

    //an array with all the images (ba meta key). The same array has to be in wpnpg_multiple_images_meta_box_save($post_id) as well.
    $meta_keys = array('wpnpg_second_iamge','wpnpg_third_iamge','wpnpg_fourth_iamge','wpnpg_fifth_iamge','wpnpg_sixth_iamge');

    foreach($meta_keys as $meta_key){
        $image_meta_val=get_post_meta( $post->ID, $meta_key, true);
        ?>
<div class="wpnpg_multiple_images_wrapper" id="<?php echo $meta_key; ?>_wrapper"> <img src="<?php echo ($image_meta_val!=''?wp_get_attachment_image_src( $image_meta_val)[0]:''); ?>" style="display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" alt=""> <a class="addimage button" onclick="wpnpg_multiple_images_add_image('<?php echo $meta_key; ?>');">
  <?php _e('Add Image','wpnpg'); ?>
  </a> <a class="removeimage button" style="display: <?php echo ($image_meta_val!=''?'block':'none'); ?>" onclick="wpnpg_multiple_images_remove_image('<?php echo $meta_key; ?>');">
  <?php _e('Remove Image','wpnpg'); ?>
  </a>
  <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
</div>
<?php } ?>
<script>
    function wpnpg_multiple_images_add_image(key){

        var $wrapper = jQuery('#'+key+'_wrapper');

        wpnpg_multiple_images_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('select image','wpnpg'); ?>',
            button: {
                text: '<?php _e('select image','wpnpg'); ?>'
            },
            multiple: false
        });
        wpnpg_multiple_images_uploader.on('select', function() {

            var attachment = wpnpg_multiple_images_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
            $wrapper.find('a.removeimage').show();
        });
        wpnpg_multiple_images_uploader.on('open', function(){
            var selection = wpnpg_multiple_images_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        wpnpg_multiple_images_uploader.open();
        return false;
    }

    function wpnpg_multiple_images_remove_image(key){
        var $wrapper = jQuery('#'+key+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
        $wrapper.find('a.removeimage').hide();
        return false;
    }
    </script>
<?php
    wp_nonce_field( 'wpnpg_multiple_images_meta_box', 'wpnpg_multiple_images_meta_box_nonce' );
}
// save data from wpnpg_multiple_images_meta_box_nonce 
function wpnpg_multiple_images_meta_box_save($post_id){

    if ( ! current_user_can( 'edit_posts', $post_id ) ){ return 'not permitted'; }

    if (isset( $_POST['wpnpg_multiple_images_meta_box_nonce'] ) && wp_verify_nonce($_POST['wpnpg_multiple_images_meta_box_nonce'],'wpnpg_multiple_images_meta_box' )){

        //same array as in wpnpg_multiple_images_meta_box_func($post)
        $meta_keys = array('wpnpg_second_iamge','wpnpg_third_iamge','wpnpg_fourth_iamge','wpnpg_fifth_iamge','wpnpg_sixth_iamge');
        foreach($meta_keys as $meta_key){
            if(isset($_POST[$meta_key]) && intval($_POST[$meta_key])!=''){
                update_post_meta( $post_id, $meta_key, intval($_POST[$meta_key]));
            }else{
                update_post_meta( $post_id, $meta_key, '');
            }
        }
    }
}

/**
	Register plugin short code. 
**/
function wpnpg_gallery_shortcode_functions()
{
	return wpnpg_photo_gallery_loop();
}
add_shortcode('WPNPG-GALLERY', 'wpnpg_photo_gallery_loop');

/**
	Create new pages for photo gallery.
**/
function wpnpg_page_creation_function()
  {
   //post status and options
    $post = array(
          //'comment_status' => 'closed',
          'ping_status' =>  'closed' ,
          'post_author' => 1,
          'post_name' => 'photo-gallery',
          'post_status' => 'publish' ,
          'post_title' => 'Photo Gallery',
          'post_type' => 'page',
		  'post_content'  => '[WPNPG-GALLERY]',
    );  
    //insert page and save the id
    $wpnpgvalue = wp_insert_post( $post, false );
    //save the id in the database
    update_option( 'wpnpg', $wpnpgvalue );
  }
  register_activation_hook( __FILE__, 'wpnpg_page_creation_function');

/**
	Redirect to plugin settings page.
**/
register_activation_hook(__FILE__, 'wpnpg_plugin_activate');
add_action('admin_init', 'wpnpg_plugin_redirect');

function wpnpg_plugin_activate() {
    add_option('wpnpg_plugin_do_activation_redirect', true);
}

function wpnpg_plugin_redirect() {
    if (get_option('wpnpg_plugin_do_activation_redirect', false)) {
        delete_option('wpnpg_plugin_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("edit.php?post_type=wpnpg&page=wpnpg-slider-page");
        }
    }
}
