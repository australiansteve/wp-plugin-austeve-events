<?php
/**
 * Plugin Name: Events - Canvas & Cocktails
 * Plugin URI: https://github.com/australiansteve/wp-plugin-austeve-events
 * Description: Showcase a series of events
 * Version: 0.0.1
 * Author: AustralianSteve
 * Author URI: http://AustralianSteve.com
 * License: GPL2
 */

include( plugin_dir_path( __FILE__ ) . 'admin.php');
include( plugin_dir_path( __FILE__ ) . 'shortcode.php');
include( plugin_dir_path( __FILE__ ) . 'widget.php');

/*
* Creating a function to create our CPT
*/

function austeve_create_events_post_type() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Events', 'Post Type General Name', 'austeve-events' ),
		'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'austeve-events' ),
		'menu_name'           => __( 'Events', 'austeve-events' ),
		'parent_item_colon'   => __( 'Parent Event', 'austeve-events' ),
		'all_items'           => __( 'All Events', 'austeve-events' ),
		'view_item'           => __( 'View Event', 'austeve-events' ),
		'add_new_item'        => __( 'Add New Event', 'austeve-events' ),
		'add_new'             => __( 'Add New', 'austeve-events' ),
		'edit_item'           => __( 'Edit Event', 'austeve-events' ),
		'update_item'         => __( 'Update Event', 'austeve-events' ),
		'search_items'        => __( 'Search Event', 'austeve-events' ),
		'not_found'           => __( 'Not Found', 'austeve-events' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'austeve-events' ),
	);
	
// Set other options for Custom Post Type
	
	$args = array(
		'label'               => __( 'Events', 'austeve-events' ),
		'description'         => __( 'Canvas & Cocktail Events', 'austeve-events' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'author', 'revisions', ),
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		'taxonomies'          => array( 'event-type'),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/	
		'hierarchical'        => false,
		'rewrite'           => array( 'slug' => 'events' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => array( 'event' , 'events' ),
        'map_meta_cap'        => true,
		'menu_icon'				=> 'dashicons-calendar-alt',
	);
	
	// Registering your Custom Post Type
	register_post_type( 'austeve-events', $args );


	$taxonomyLabels = array(
		'name'              => _x( 'Event Types', 'taxonomy general name' ),
		'singular_name'     => _x( 'Event Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Event Types' ),
		'all_items'         => __( 'All Event Types' ),
		'parent_item'       => __( 'Parent Event Type' ),
		'parent_item_colon' => __( 'Parent Event Type:' ),
		'edit_item'         => __( 'Edit Event Type' ),
		'update_item'       => __( 'Update Event Type' ),
		'add_new_item'      => __( 'Add New Event Type' ),
		'new_item_name'     => __( 'New Event Type Name' ),
		'menu_name'         => __( 'Event Types' ),
	);

	$taxonomyArgs = array(

		'label'               => __( 'austeve_event_types', 'austeve-events' ),
		'labels'              => $taxonomyLabels,
		'show_admin_column'	=> false,
		'hierarchical' 		=> false,
		'show_ui'			=> false,
		'rewrite'           => array( 'slug' => 'event-type' ),
		'capabilities'		=> array(
							    'manage_terms' => 'edit_users',
							    'edit_terms' => 'edit_users',
							    'delete_terms' => 'edit_users',
							    'assign_terms' => 'edit_posts'
							 )
		);

	register_taxonomy( 'austeve_event_types', 'austeve-events', $taxonomyArgs );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/

add_action( 'init', 'austeve_create_events_post_type', 0 );

function event_include_template_function( $template_path ) {
    if ( get_post_type() == 'austeve-events' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-events.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-events.php';
            }
        }
        else if ( is_archive() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'archive-events.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/archive-events.php';
            }
        }
    }
    return $template_path;
}
add_filter( 'template_include', 'event_include_template_function', 1 );

function event_filter_archive_title( $title ) {

    if( is_tax('austeve_event_types' ) ) {

        $title = single_cat_title( '', false ) . ' events';

    }
    else if ( is_post_type_archive('austeve-events') ) {

        $title = post_type_archive_title( '', false );

    }

    return $title;

}

add_filter( 'get_the_archive_title', 'event_filter_archive_title');

function austeve_events_enqueue_style() {
	wp_enqueue_style( 'austeve-events', plugin_dir_url( __FILE__ ). '/style.css' , false , '4.6'); 
}

function austeve_events_enqueue_script() {
	//wp_enqueue_script( 'my-js', 'filename.js', false );
}

add_action( 'wp_enqueue_scripts', 'austeve_events_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'austeve_events_enqueue_script' );

function pre_get_posts_order_events( $query ) {
	
	// do not modify queries in the admin
	if( is_admin() ) {
		
		return $query;
		
	}

	// only modify queries for 'event' post type
	if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'austeve-events' ) {
		
		// find date time now
		$date_now = date('Y-m-d H:i:s');

		//Find the next 2 events
		$query->set('posts_per_page', 2);	
		$query->set('orderby', 'meta_value');	
		$query->set('meta_key', 'date');	 	
		$query->set('meta_type', 'DATETIME');	 
		$query->set('order', 'ASC');	 
		$query->set('meta_query', array(
	        'key'			=> 'date',
	        'compare'		=> '>=',
	        'value'			=> $date_now,
	        'type'			=> 'DATETIME',
	    ));
	}

	// return
	return $query;

}

add_action('pre_get_posts', 'pre_get_posts_order_events');


//Shortcode

?>