<?php
/**
 * Register a book post type, with REST API support
 *
 * Based on example at: http://codex.wordpress.org/Function_Reference/register_post_type
 */
add_action( 'init', 'project_cpt' );
function project_cpt() {
	$labels = array(
		'name'               => _x( 'Projects', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Project', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Projects', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'project', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Project', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Project', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Project', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Project', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Projects', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Projects', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Projects:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Projects found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Projects found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'project' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'show_in_rest'       => true,
		'rest_base'          => 'projects',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'project', $args );
}
// change better featured images plugin priority
add_action( 'plugins_loaded', function() {
    remove_action( 'init', 'better_rest_api_featured_images_init', 12 );
    add_action( 'init', 'better_rest_api_featured_images_init', 99 );
});

if ( ! function_exists( 'HM\\Autoloader\\register_class_path' ) ) {
	require_once 'inc/autoloader.php';
}

HM\Autoloader\register_class_path( 'FeelingRESTful', dirname( __FILE__ ) . '/inc' );

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_script( 'app', get_template_directory_uri() . '/dist/main.js', array(), wp_get_theme()->Version, true );
	wp_localize_script( 'app', 'app_data', array(
		'api_url' => untrailingslashit( rest_url() ),
		'nonce'   => wp_create_nonce( 'wp_rest' ),
	) );
	wp_enqueue_style( 'app', get_template_directory_uri() . '/dist/main.css', array(), wp_get_theme()->Version );
} );

show_admin_bar( false );

add_post_type_support( 'page', 'modular-page-builder' );

add_theme_support( 'post-thumbnails' );

add_action( 'admin_init', function() {
	remove_post_type_support( 'page', 'editor' );
	remove_post_type_support( 'page', 'discussion' );
	remove_post_type_support( 'page', 'comments' );
	remove_post_type_support( 'page', 'page-attributes' );
	remove_post_type_support( 'page', 'custom-fields' );
	remove_post_type_support( 'page', 'thumbnail' );
	remove_post_type_support( 'page', 'author' );
} );

add_action( 'init', function() {

	if ( ! class_exists( 'ModularPageBuilder\\Plugin' ) ) {
		return;
	}

	$plugin = ModularPageBuilder\Plugin::get_instance();
	$plugin->register_module( 'map', 'FeelingRESTful\\Page_Builder_Modules\\Map' );
	$plugin->register_module( 'twitter_timeline', 'FeelingRESTful\\Page_Builder_Modules\\Twitter_Timeline' );

	// Part of enabling previews
	$preview_postmeta = new FeelingRESTful\Preview_Postmeta();

	// Opengraph
	$opengraph = new FeelingRESTful\OpenGraph();
} );

add_filter( 'modular_page_builder_allowed_modules_for_page', function( $allowed ) {
	$allowed[] = 'map';
	$allowed[] = 'twitter_timeline';
	return $allowed;
} );

add_action( 'init', function() {
	global $wp_rewrite;
	$wp_rewrite->permalink_structure = $wp_rewrite->root . 'news/%postname%';
	$wp_rewrite->page_structure      = $wp_rewrite->root . 'page/%pagename%';
} );

add_filter( 'pre_option_permalink_structure', function() {
	return '/news/%postname%';
} );

add_filter( 'qm/dispatch/html', '__return_false' );

/**
 * Send preview data instead.
 */
add_filter( 'rest_prepare_page', function( WP_REST_Response $response, WP_Post $post, WP_REST_Request $request ) {

	$is_preview = false !== strpos( $request->get_header( 'referer' ), 'preview=true' );
	$post_type  = get_post_type_object( $post->post_type );

	$_GET['preview']     = 'true';
	$_POST['wp-preview'] = 'dopreview';

	if ( 'GET' === $request->get_method() && current_user_can( $post_type->cap->edit_post, $post->ID ) && $is_preview ) {
		$post = _set_preview( $post );

		$data = $response->get_data();

		$data['content'] = array(
			'raw'      => $post->post_content,
			'rendered' => apply_filters( 'the_content', $post->post_content ),
		);

		$data['title'] = array(
			'raw'      => $post->post_title,
			'rendered' => apply_filters( 'the_title', $post->post_title, $post->ID ),
		);

		$data['excerpt'] = array(
			'raw'      => $post->post_excerpt,
			'rendered' => apply_filters( 'the_excerpt', apply_filters( 'get_the_excerpt', $post->post_excerpt ) ),
		);

		$response->set_data( $data );
	}

	return $response;
}, 10, 3 );

/**
 * Set preview $_GET / $_POST early as possible.
 */
add_filter( 'rest_enabled', function( $enabled ) {

	if (
		$enabled &&
		'GET' === $_SERVER['REQUEST_METHOD'] &&
		false !== strpos( $_SERVER['HTTP_REFERER'], 'preview=true' )
	) {
		$_GET['preview']     = 'true';
		$_POST['wp-preview'] = 'dopreview';
	}

	return $enabled;
}, 10 );

/**
 * Polyfill for wp_title()
 */
add_filter( 'wp_title', function( $title, $sep, $seplocation ) {

	if ( false !== strpos( $title, __( 'Page not found' ) ) ) {
		$replacement = ucwords( str_replace( '/', ' ', $_SERVER['REQUEST_URI'] ) );
		$title = str_replace( __( 'Page not found' ), $replacement, $title );
	}

	return $title;
}, 10, 3 );
