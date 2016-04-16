<?php
/**
 * Template part for displaying single projects.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * 
 * @package ChurchPew Projects
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<div class="description">
		<?php echo get_field('project_description'); ?>
		</div>

		<div class="date">
		<?php 
			$date = get_field('project_date');
			// $date = 19881123 (23/11/1988)

			// extract Y,M,D
			$y = substr($date, 0, 4);
			$m = substr($date, 4, 2);
			$d = substr($date, 6, 2);

			// create UNIX
			$time = strtotime("{$d}-{$m}-{$y}");

			//Time right now
			$now = new DateTime();
			$currentTime = $now->getTimestamp();

			if ($currentTime < $time) {
				echo "Coming: ";
			}

			// format date (November 11th 1988)
			echo date('F Y', $time);
		?>
		</div>

		<div class="client">
		<?php echo get_field('project_client'); ?>
		</div>

		<div class="materials">
		<?php echo get_field('project_materials'); ?>
		</div>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'churchpew' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php churchpew_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
