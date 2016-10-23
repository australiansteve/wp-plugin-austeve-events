<?php
/**
 * The template for displaying all single events.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package AUSteve Events
 */

get_header(); ?>

<div class="row"><!-- .row start -->

	<div class="small-12 columns"><!-- .columns start -->

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php 

            		if (locate_template('page-templates/partials/events-single.php') != '') {
						// yep, load the page template
						get_template_part('page-templates/partials/events', 'single');
					} else {
						// nope, load the default
						include( plugin_dir_path( __FILE__ ) . 'page-templates/partials/events-single.php');
					}

				?>
				
				<?php 
				the_post_navigation(array(
			        'prev_text'          => '<i class="fa fa-arrow-left"></i> Previous',
			        'next_text'          => 'Next <i class="fa fa-arrow-right"></i>',
			        'screen_reader_text' => __( 'More events:' ),
			    )); ?>

			<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- .columns end -->

</div><!-- .row end -->

<?php get_footer(); ?>
