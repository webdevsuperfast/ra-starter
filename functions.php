<?php
/**
 * Functions
 *
 * @package      RA Starter
 * @author       Rotsen Mark Acob
 * @since        1.0.0
 * @license      GPL-2.0+
**/

require get_template_directory() . '/inc/tha-theme-hooks.php';
require get_template_directory() . '/inc/wordpress-cleanup.php';
require get_template_directory() . '/inc/login-logo.php';
require get_template_directory() . '/inc/helper-functions.php';
require get_template_directory() . '/inc/navigation.php';
//require get_template_directory() . '/inc/sidebar-layouts.php';
//require get_template_directory() . '/inc/custom-logo.php';
require get_template_directory() . '/inc/loop.php';
require get_template_directory() . '/inc/tinymce.php';
require get_template_directory() . '/inc/disable-editor.php';
require get_template_directory() . '/inc/amp.php';
require get_template_directory() . '/inc/display-posts.php';
require get_template_directory() . '/inc/wpforms.php';

/**
 * Enqueue scripts and styles.
 */
function ra_scripts() {

	wp_enqueue_style( 'ra-fonts', ra_theme_fonts_url() );
	wp_enqueue_style( 'ra-style', get_template_directory_uri() . '/assets/css/main.css', array(), filemtime( get_template_directory() . '/assets/css/main.css' ) );

	wp_enqueue_script( 'ra-smoothscroll', get_template_directory_uri() . '/assets/js/smoothscroll.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/smoothscroll.min.js' ), true );
	
	wp_enqueue_script( 'ra-global', get_template_directory_uri() . '/assets/js/global.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/global.min.js' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Move jQuery to footer
	if( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
		wp_enqueue_script( 'jquery' );
	}
}
add_action( 'wp_enqueue_scripts', 'ra_scripts' );

/**
 * Gutenberg scripts and styles
 *
 */
function ra_gutenberg_scripts() {
	wp_enqueue_style( 'ra-fonts', ra_theme_fonts_url() );
	wp_enqueue_script( 'ra-editor', get_template_directory_uri() . '/assets/js/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_template_directory() . '/assets/js/editor.js' ), true );
}
add_action( 'enqueue_block_editor_assets', 'ra_gutenberg_scripts' );

/**
 * Theme Fonts URL
 *
 */
function ra_theme_fonts_url() {
	$font_families = apply_filters( 'ra_theme_fonts', array( 'Source+Sans+Pro:400,400i,700,700i' ) );
	$query_args = array(
		'family' => implode( '|', $font_families ),
		'subset' => 'latin,latin-ext',
	);
	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	return esc_url_raw( $fonts_url );
}

if ( ! function_exists( 'ra_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ra_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'ra-starter', get_template_directory() . '/languages' );

	// Editor Styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Admin Bar Styling
	add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Body open hook
	add_theme_support( 'body-open' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 */
	 $GLOBALS['content_width'] = apply_filters( 'ra_content_width', 1024 );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'ra-starter' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Gutenberg

	// -- Responsive embeds
	add_theme_support( 'responsive-embeds' );

	// -- Wide Images
	add_theme_support( 'align-wide' );

	// -- Disable custom font sizes
	add_theme_support( 'disable-custom-font-sizes' );

	// -- Editor Font Styles
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => __( 'small', 'ra-starter' ),
			'shortName' => __( 'S', 'ra-starter' ),
			'size'      => 12,
			'slug'      => 'small'
		),
		array(
			'name'      => __( 'regular', 'ra-starter' ),
			'shortName' => __( 'M', 'ra-starter' ),
			'size'      => 16,
			'slug'      => 'regular'
		),
		array(
			'name'      => __( 'large', 'ra-starter' ),
			'shortName' => __( 'L', 'ra-starter' ),
			'size'      => 20,
			'slug'      => 'large'
		),
	) );

	// -- Disable Custom Colors
	add_theme_support( 'disable-custom-colors' );

	// -- Editor Color Palette
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Blue', 'ra-starter' ),
			'slug'  => 'blue',
			'color'	=> '#59BACC',
		),
		array(
			'name'  => __( 'Green', 'ra-starter' ),
			'slug'  => 'green',
			'color' => '#58AD69',
		),
		array(
			'name'  => __( 'Orange', 'ra-starter' ),
			'slug'  => 'orange',
			'color' => '#FFBC49',
		),
		array(
			'name'	=> __( 'Red', 'ra-starter' ),
			'slug'	=> 'red',
			'color'	=> '#E2574C',
		),
	) );

}
endif;
add_action( 'after_setup_theme', 'ra_setup' );

/**
 * Template Hierarchy
 *
 */
function ra_template_hierarchy( $template ) {

	if( is_home() || is_search() )
		$template = get_query_template( 'archive' );
	return $template;
}
add_filter( 'template_include', 'ra_template_hierarchy' );
