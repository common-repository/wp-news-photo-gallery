<?php
/**
 * The template for displaying single photo gallery.
 *
 */
get_header(); 

/**
	Diusplay gallery images
**/

while ( have_posts() ) : the_post(); ?>
<!-- #start post-## -->

<div class="wpnpg-container wpnpg-section">
  <div class="wpnpg-row" >
    <div class="col-md-9 col-sm-6 col-xs-12">
        <h1 class="entry-title"><a href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
          </a></h1>
        <!-- start content -->
        <?php the_content(); ?>
        <p class="wpnpg-single-image"> <?php echo wp_get_attachment_image(get_post_meta(get_the_ID(), 'wpnpg_second_iamge', true),'full'); ?> <?php echo wp_get_attachment_image(get_post_meta(get_the_ID(), 'wpnpg_third_iamge', true),'full'); ?> <?php echo wp_get_attachment_image(get_post_meta(get_the_ID(), 'wpnpg_fourth_iamge', true),'full'); ?> <?php echo wp_get_attachment_image(get_post_meta(get_the_ID(), 'wpnpg_fifth_iamge', true),'full'); ?> <?php echo wp_get_attachment_image(get_post_meta(get_the_ID(), 'wpnpg_sixth_iamge', true),'full'); ?> </p>
        <!-- end content --> 
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
    <?php dynamic_sidebar('wpnpg-widget'); ?>
    </div>
  </div>
</div>
<!-- #end post-## -->
<?php endwhile;
get_footer(); ?>