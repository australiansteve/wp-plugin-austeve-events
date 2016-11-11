<?php
/**
 * Template part for displaying archived events.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * 
 * @package AUSteve Events
 */
?>
<?php 
	$image = get_field('image'); 
	$paddingClass='';
	if( have_rows('image') ){

	     // loop through the rows of data - there should only be 1 though
	    while ( have_rows('image') ) : the_row();

	        if( get_row_layout() == 'event_image' ){
	        	$paddingClass='padded';
	        }

	    endwhile;
    }
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $paddingClass ); ?>>
	
	<div class="corner-background corner-background-1">&nbsp;</div>
	<div class="corner-background corner-background-2">&nbsp;</div>
	<div class="corner-background corner-background-3">&nbsp;</div>
	<div class="corner-background corner-background-4">&nbsp;</div>
	<div class="entry-content">

		<?php 
			$image = get_field('image'); 

			//var_dump($image);

			//var_dump($image[0]["poster"]);

			if( have_rows('image') ){

			     // loop through the rows of data - there should only be 1 though
			    while ( have_rows('image') ) : the_row();

			        if( get_row_layout() == 'event_poster' ):

			        	$poster = get_sub_field('poster');
			        ?>
						<div class="row columns">
				        	<img src="<?php echo $poster['url'];?>" alt="<?php echo $poster['alt'];?>" />
						</div>
			       	<?php
			        elseif( get_row_layout() == 'event_image' ): 

			        	$eventImage = get_sub_field('image');
			        ?>
						<div class="row">
				        	<div class="small-12 columns">
				        		<img src="<?php echo $eventImage['url'];?>" alt="<?php echo $eventImage['alt'];?>" />
				        	</div>
						</div>
						<div class="row columns">
				        	<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header><!-- .entry-header -->
						</div>
						<div class="row columns">
			        		<?php echo get_field('date'); ?>
						</div>
						<div class="row columns">
			        		<?php echo get_field('venue'); ?>
						</div>
			        <?php
			        endif;

			    endwhile;
			}
			else {

			    echo "<h3><strong>No event image saved - ERROR!</strong></h3>";

			}
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'austeve-events' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
