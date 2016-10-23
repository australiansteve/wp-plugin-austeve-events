<?php
/* Shortcode file */

function austeve_events_upcoming(){
	ob_start();

	// find date time now
	$date_now = date('Y-m-d H:i:s');

	$meta_query = array(
        'key'			=> 'date',
        'compare'		=> '>=',
        'value'			=> $date_now,
        'type'			=> 'DATETIME',
    );


    $args = array(
        'post_type' => 'austeve-events',
        'post_status' => array('publish'),
        'meta_key'        => 'date',
        'meta_type'        => 'DATETIME',
        'orderby'        => 'meta_value',
    	'order'          => 'ASC',
		'posts_per_page' => 2,
		'paged' 		=> false,
		'meta_query' => $meta_query
    );
    //var_dump($args);
    $query = new WP_Query( $args );
	
    if( $query->have_posts() ){

		echo "<div class='row small-up-1 medium-up-2 large-up-3 align-middle' id='events-block-grid'>";

		//loop over query results
        while( $query->have_posts() ){
            $query->the_post();
            
            echo '<div class="column">';
            include( plugin_dir_path( __FILE__ ) . 'page-templates/partials/events-archive.php');
    		echo '</div>';
        }

    	echo '</div>';

    }
    else {
?>
		<div class="row archive-container">
		  	<div class="col-xs-12">
		  		<em>No results found.</em>
		  	</div>
	  	</div>
<?php	
    }
    
    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode( 'upcoming_events', 'austeve_events_upcoming' );

?>
