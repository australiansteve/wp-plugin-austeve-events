<?php
/**
 * Plugin Name: Events - Custom Post Type
 * Plugin URI: https://github.com/australiansteve/wp-plugin-austeve-events
 * Description: Showcase a portfolio of projects
 * Version: 0.1.2
 * Author: AustralianSteve
 * Author URI: http://AustralianSteve.com
 * License: GPL2
 */

include( plugin_dir_path( __FILE__ ) . 'admin.php');
include( plugin_dir_path( __FILE__ ) . 'widget.php');

/*
* Creating a function to create our CPT
*/

function austeve_create_projects_post_type() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Projects', 'Post Type General Name', 'austeve-projects' ),
		'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'austeve-projects' ),
		'menu_name'           => __( 'Projects', 'austeve-projects' ),
		'parent_item_colon'   => __( 'Parent Project', 'austeve-projects' ),
		'all_items'           => __( 'All Projects', 'austeve-projects' ),
		'view_item'           => __( 'View Project', 'austeve-projects' ),
		'add_new_item'        => __( 'Add New Project', 'austeve-projects' ),
		'add_new'             => __( 'Add New', 'austeve-projects' ),
		'edit_item'           => __( 'Edit Project', 'austeve-projects' ),
		'update_item'         => __( 'Update Project', 'austeve-projects' ),
		'search_items'        => __( 'Search Project', 'austeve-projects' ),
		'not_found'           => __( 'Not Found', 'austeve-projects' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'austeve-projects' ),
	);
	
// Set other options for Custom Post Type
	
	$args = array(
		'label'               => __( 'Projects', 'austeve-projects' ),
		'description'         => __( 'Projects of any type', 'austeve-projects' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'author', 'revisions', ),
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		'taxonomies'          => array( 'project-type'),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/	
		'hierarchical'        => false,
		'rewrite'           => array( 'slug' => 'projects' ),
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
		'capability_type'     => 'page',
	);
	
	// Registering your Custom Post Type
	register_post_type( 'austeve-projects', $args );


	$taxonomyLabels = array(
		'name'              => _x( 'Project Types', 'taxonomy general name' ),
		'singular_name'     => _x( 'Project Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Project Types' ),
		'all_items'         => __( 'All Project Types' ),
		'parent_item'       => __( 'Parent Project Type' ),
		'parent_item_colon' => __( 'Parent Project Type:' ),
		'edit_item'         => __( 'Edit Project Type' ),
		'update_item'       => __( 'Update Project Type' ),
		'add_new_item'      => __( 'Add New Project Type' ),
		'new_item_name'     => __( 'New Project Type Name' ),
		'menu_name'         => __( 'Project Types' ),
	);

	$taxonomyArgs = array(

		'label'               => __( 'austeve_project_types', 'austeve-projects' ),
		'labels'              => $taxonomyLabels,
		'show_admin_column'	=> false,
		'hierarchical' 		=> true,
		'rewrite'           => array( 'slug' => 'project-type' ),
		'capabilities'		=> array(
							    'manage_terms' => 'edit_users',
							    'edit_terms' => 'edit_users',
							    'delete_terms' => 'edit_users',
							    'assign_terms' => 'edit_posts'
							 )
		);

	register_taxonomy( 'austeve_project_types', 'austeve-projects', $taxonomyArgs );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/

add_action( 'init', 'austeve_create_projects_post_type', 0 );

function project_include_template_function( $template_path ) {
    if ( get_post_type() == 'austeve-projects' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-projects.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-projects.php';
            }
        }
        else if ( is_archive() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'archive-projects.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/archive-projects.php';
            }
        }
    }
    return $template_path;
}
add_filter( 'template_include', 'project_include_template_function', 1 );

function project_filter_archive_title( $title ) {

    if( is_tax('austeve_project_types' ) ) {

        $title = single_cat_title( '', false ) . ' projects';

    }
    else if ( is_post_type_archive('austeve-projects') ) {

        $title = post_type_archive_title( '', false );

    }

    return $title;

}

add_filter( 'get_the_archive_title', 'project_filter_archive_title');

function austeve_projects_enqueue_style() {
	wp_enqueue_style( 'austeve-projects', plugin_dir_url( __FILE__ ). '/style.css' , false , '4.6'); 
}

function austeve_projects_enqueue_script() {
	//wp_enqueue_script( 'my-js', 'filename.js', false );
}

add_action( 'wp_enqueue_scripts', 'austeve_projects_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'austeve_projects_enqueue_script' );

if ( ! function_exists( 'austeve_projects_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function austeve_projects_entry_footer() {
	
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'austeve-projects' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

?>