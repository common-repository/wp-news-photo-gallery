<?php
/**
 * The template for displaying all archive photo gallery.
 *
 */
get_header(); 

/**
	Diusplay gallery images
**/
?>

<div class="wpnpg-container wpnpg-section">
  <div class="wpnpg-row">
    <div class="col-md-9 col-sm-6 col-xs-12">
      <div class="wpnpg-row">
        <?php if ( have_posts() ) : ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="wpnpg-row">
            <?php the_archive_title( '<h1 class="entry-title">', '</h1>' ); ?>
            <?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();?>
            <div class="col-md-3 col-sm-6 col-xs-12 pull-left"> <a href="<?php the_permalink(); ?>" target="_blank">
              <?php the_post_thumbnail('medium', array('class' => 'img-responsive')); ?>
              </a> <a href="<?php the_permalink(); ?>" target="_blank">
              <?php the_title(); ?>
              </a> </div>
            <?php // End the loop. 
			endwhile; ?>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="wpnpg-row">
            <?php 
			// Previous/next page navigation.
			the_posts_pagination(
				array(
					'prev_text'          => __( 'Previous Page', 'wpnpg' ),
					'next_text'          => __( 'Next Page', 'wpnpg' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'wpnpg' ) . ' </span>',
				)
			); ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
    <?php dynamic_sidebar('wpnpg-widget'); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>