<?php

function austeve_populate_event_types() {

	$taxonomy = 'austeve_event_types';

	if (!term_exists( 'Public', $taxonomy ) ) 
	{
		wp_insert_term(
			'Public', // the term 
			$taxonomy, // the taxonomy
			array(
				'description'=> 'Public event',
				'slug' => 'austeve-event-public'
			)
		);
	}

	if (!term_exists( 'Private', $taxonomy ) ) 
	{
		wp_insert_term(
			'Private', // the term 
			$taxonomy, // the taxonomy
			array(
				'description'=> 'Private event',
				'slug' => 'austeve-event-private'
			)
		);
	}
}

add_action('admin_init','austeve_populate_event_types', 999);

//After an Event has been saved, update the austeve_event_types taxonomy with saved values
function austeve_update_post_event_type( $post_id ) {
    
	$taxonomy = 'austeve_event_types';
	error_log("austeve_update_post_event_type: ");

    // get new value
    $value = get_field('event_type');

    if ($value)
    {
		error_log($value['value']);
    	$assignedTerms = wp_get_post_terms( $post_id, $taxonomy );
    	$slug = 'austeve-event-'.$value['value'];
    	$term = term_exists( $slug, $taxonomy );

    	//Should always be the case, since we are only using 2 preset values (public/private)
    	if ($term)
    	{
			$alreadyAssigned = false;

	    	if ($assignedTerms)
	    	{
	    		foreach($assignedTerms as $assignedTerm)
	    		{
	    			if ($assignedTerm->term_id != $term['term_id'])
	    			{
	    				//var_dump($assignedTerm);
	    				error_log("Removing: Term ".$assignedTerm->term_id. " from post_id ".$post_id);
	    				wp_remove_object_terms( $post_id, $assignedTerm->term_id, $taxonomy );
	    			}
	    			else 
	    			{
	    				$alreadyAssigned = true;
	    			}
	    		}
	    	}

	    	if (!$alreadyAssigned)
	    	{
	    		error_log("Assigning: Term ".$term['term_id']. " to post_id ".$post_id);
	    		wp_set_post_terms( $post_id, array( intval($term['term_id']) ), $taxonomy );
	    	}
    	}

    }
}

add_action('acf/save_post', 'austeve_update_post_event_type', 20);

//Filter the admin call for Events based on the current users role(s) - Only display events that the user has access to
function austeve_filter_events_for_admins( $query ) {
    
	if (!is_admin() ||  //Not in admin screens 
		(isset($query->query_vars['post_type']) && $query->query_vars['post_type'] != 'austeve-events' ) || //Not on an events admin page
		current_user_can('edit_users') ) //Has access to all regions/locations
	{
		return $query;
	}

	//If we get here the current user has access to view locations, therefore they should be able to set Regions

	//Get current user roles
	$roles = wp_get_current_user()->roles;
	$my_terms = austeve_get_my_terms($roles);
	error_log(print_r( $my_terms, true ));

	//Get all locations in the users allowed region(s)
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'ID',
		'order'            => 'ASC',
		'post_type'        => 'austeve-locations',
		'post_status'      => 'publish',
		'suppress_filters' => false 
	);
	$locations_array = get_posts( $args );
	error_log(print_r( $locations_array, true ));

	$meta_query = array(
		array(
			'key'     => 'location',
			'value'   => implode(",", array_column($locations_array, 'ID')),
			'compare' => 'IN',
			'type'    => 'NUMERIC',
		),
	);

	$query->set( 'meta_query', $meta_query );
	error_log(print_r( $query, true ));
}

add_action( 'pre_get_posts', 'austeve_filter_events_for_admins' , 10, 1 );

?>