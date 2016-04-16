<?php
/**
 * Plugin Name: Projects CPT
 * Plugin URI: https://github.com/australiansteve/wp-plugin-austeve-churchpew-projects
 * Description: Showcase a portfolio of projects
 * Version: 0.0.8
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
		'name'                => _x( 'Projects', 'Post Type General Name', 'churchpew' ),
		'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'churchpew' ),
		'menu_name'           => __( 'Projects', 'churchpew' ),
		'parent_item_colon'   => __( 'Parent Project', 'churchpew' ),
		'all_items'           => __( 'All Projects', 'churchpew' ),
		'view_item'           => __( 'View Project', 'churchpew' ),
		'add_new_item'        => __( 'Add New Project', 'churchpew' ),
		'add_new'             => __( 'Add New', 'churchpew' ),
		'edit_item'           => __( 'Edit Project', 'churchpew' ),
		'update_item'         => __( 'Update Project', 'churchpew' ),
		'search_items'        => __( 'Search Project', 'churchpew' ),
		'not_found'           => __( 'Not Found', 'churchpew' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'churchpew' ),
	);
	
// Set other options for Custom Post Type
	
	$args = array(
		'label'               => __( 'Projects', 'churchpew' ),
		'description'         => __( 'Custom & commercial projects', 'churchpew' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'author', 'thumbnail', 'revisions', ),
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
	register_post_type( 'churchpew-projects', $args );


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

		'label'               => __( 'churchpew_project_types', 'churchpew' ),
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

	register_taxonomy( 'churchpew_project_types', 'churchpew-projects', $taxonomyArgs );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/

add_action( 'init', 'austeve_create_projects_post_type', 0 );

function project_include_template_function( $template_path ) {
    if ( get_post_type() == 'churchpew-projects' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-churchpew-projects.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-churchpew-projects.php';
            }
        }
        else if ( is_archive() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'archive-churchpew-projects.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/archive-churchpew-projects.php';
            }
        }
    }
    return $template_path;
}
add_filter( 'template_include', 'project_include_template_function', 1 );

function project_filter_archive_title( $title ) {

    if( is_tax('churchpew_project_types' ) ) {

        $title = single_cat_title( '', false ) . ' projects';

    }
    else if ( is_post_type_archive('churchpew-projects') ) {

        $title = post_type_archive_title( '', false );

    }

    return $title;

}

add_filter( 'get_the_archive_title', 'project_filter_archive_title');

?>