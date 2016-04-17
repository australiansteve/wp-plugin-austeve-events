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

		<div class="gallery">
		<?php 
			$gallery_images = get_field('project_gallery'); 
			
			//SAMPLE: array(3) { [0]=> array(18) { ["ID"]=> int(317) ["id"]=> int(317) ["title"]=> string(15) "hamburger cat 2" ["filename"]=> string(19) "hamburger-cat-2.png" ["url"]=> string(73) "http://localhost/theme-dev/wp-content/uploads/2015/10/hamburger-cat-2.png" ["alt"]=> string(0) "" ["author"]=> string(1) "1" ["description"]=> string(0) "" ["caption"]=> string(0) "" ["name"]=> string(15) "hamburger-cat-2" ["date"]=> string(19) "2015-10-29 02:23:42" ["modified"]=> string(19) "2015-10-29 02:23:42" ["mime_type"]=> string(9) "image/png" ["type"]=> string(5) "image" ["icon"]=> string(63) "http://localhost/theme-dev/wp-includes/images/media/default.png" ["width"]=> int(1603) ["height"]=> int(1407) ["sizes"]=> array(12) { ["thumbnail"]=> string(81) "http://localhost/theme-dev/wp-content/uploads/2015/10/hamburger-cat-2-150x150.png" ["thumbnail-width"]=> int(150) ["thumbnail-height"]=> int(150) ["medium"]=> string(81) "http://localhost/theme-dev/wp-content/uploads/2015/10/hamburger-cat-2-300x263.png" ["medium-width"]=> int(300) ["medium-height"]=> int(263) ["medium_large"]=> string(73) "http://localhost/theme-dev/wp-content/uploads/2015/10/hamburger-cat-2.png" ["medium_large-width"]=> int(640) ["medium_large-height"]=> int(562) ["large"]=> string(82) "http://localhost/theme-dev/wp-content/uploads/2015/10/hamburger-cat-2-1024x899.png" ["large-width"]=> int(640) ["large-height"]=> int(562) } } [1]=> array(18) { ["ID"]=> int(165) ["id"]=> int(165) ["title"]=> string(14) "R03 - Tom Boyd" ["filename"]=> string(11) "3673871.jpg" ["url"]=> string(65) "http://localhost/theme-dev/wp-content/uploads/2015/04/3673871.jpg" ["alt"]=> string(0) "" ["author"]=> string(1) "1" ["description"]=> string(0) "" ["caption"]=> string(24) "Tom Boyd's big pack grab" ["name"]=> string(7) "3673871" ["date"]=> string(19) "2015-04-20 18:15:43" ["modified"]=> string(19) "2015-04-20 18:15:43" ["mime_type"]=> string(10) "image/jpeg" ["type"]=> string(5) "image" ["icon"]=> string(63) "http://localhost/theme-dev/wp-includes/images/media/default.png" ["width"]=> int(377) ["height"]=> int(450) ["sizes"]=> array(12) { ["thumbnail"]=> string(73) "http://localhost/theme-dev/wp-content/uploads/2015/04/3673871-150x150.jpg" ["thumbnail-width"]=> int(150) ["thumbnail-height"]=> int(150) ["medium"]=> string(73) "http://localhost/theme-dev/wp-content/uploads/2015/04/3673871-251x300.jpg" ["medium-width"]=> int(251) ["medium-height"]=> int(300) ["medium_large"]=> string(65) "http://localhost/theme-dev/wp-content/uploads/2015/04/3673871.jpg" ["medium_large-width"]=> int(377) ["medium_large-height"]=> int(450) ["large"]=> string(65) "http://localhost/theme-dev/wp-content/uploads/2015/04/3673871.jpg" ["large-width"]=> int(377) ["large-height"]=> int(450) } } [2]=> array(18) { ["ID"]=> int(252) ["id"]=> int(252) ["title"]=> string(5) "bl_08" ["filename"]=> string(9) "bl_08.jpg" ["url"]=> string(63) "http://localhost/theme-dev/wp-content/uploads/2015/06/bl_08.jpg" ["alt"]=> string(0) "" ["author"]=> string(1) "1" ["description"]=> string(0) "" ["caption"]=> string(0) "" ["name"]=> string(4) "if-4" ["date"]=> string(19) "2015-06-25 00:26:58" ["modified"]=> string(19) "2015-07-09 00:25:03" ["mime_type"]=> string(10) "image/jpeg" ["type"]=> string(5) "image" ["icon"]=> string(63) "http://localhost/theme-dev/wp-includes/images/media/default.png" ["width"]=> int(800) ["height"]=> int(600) ["sizes"]=> array(12) { ["thumbnail"]=> string(71) "http://localhost/theme-dev/wp-content/uploads/2015/06/bl_08-150x150.jpg" ["thumbnail-width"]=> int(150) ["thumbnail-height"]=> int(150) ["medium"]=> string(71) "http://localhost/theme-dev/wp-content/uploads/2015/06/bl_08-300x225.jpg" ["medium-width"]=> int(300) ["medium-height"]=> int(225) ["medium_large"]=> string(63) "http://localhost/theme-dev/wp-content/uploads/2015/06/bl_08.jpg" ["medium_large-width"]=> int(640) ["medium_large-height"]=> int(480) ["large"]=> string(63) "http://localhost/theme-dev/wp-content/uploads/2015/06/bl_08.jpg" ["large-width"]=> int(640) ["large-height"]=> int(480) } } }($gallery_images);

			foreach($gallery_images as $image)
			{
				echo "<img class='project-gallery-image' src='".$image['url']."'/>";
			}
		?>
		</div>

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
