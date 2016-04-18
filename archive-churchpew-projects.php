<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ChurchPew
 */

get_header(); ?>

<div class="row"><!-- .row start -->

	<div class="small-12 columns"><!-- .columns start -->

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<div class="row small-up-1 medium-up-2 large-up-4 align-middle" id="projects-block-grid">

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<div class="column">

            			<div class='container'>

				            <a href='<?php get_permalink(); ?>' class=''>

								<?php 
									$gallery = get_field('project_gallery', $post->ID); 
									//var_dump($gallery);
									if ($gallery) {
										//Use the first image in the gallery
										echo "<div class='gallery'><img src='".$gallery[0]['url']."'/></div>";
									}
									else {
										//Shouldn't happen
										echo "<div class='gallery-placeholder'>Placeholder</div>";
									}
								?>
								<br/>
								<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

				            </a>

            			</div>
					
					</div>

				<?php endwhile; ?>

				</div> <!-- #projects-block-grid -->

				<?php the_posts_navigation(); ?>

			<?php else : ?>

				<?php get_template_part( 'page-templates/partials/content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- .columns end -->

</div><!-- .row end -->

<?php get_footer(); ?>
