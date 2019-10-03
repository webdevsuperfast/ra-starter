<?php
/**
 * Sidebar Layouts
 *
 * @package      RA Starter
 * @author       Rotsen Mark Acob
 * @since        1.0.0
 * @license      GPL-2.0+
**/

 /**
  * Register widget area.
  *
  * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
  */
 function ra_widgets_init() {

 	register_sidebar( ra_widget_arra_args( array(
 		'name' => esc_html__( 'Primary Sidebar', 'ra-starter' ),
 	) ) );

 }
 add_action( 'widgets_init', 'ra_widgets_init' );

 /**
  * Layout Body Class
  *
  */
function ra_layout_body_class( $classes ) {

  $classes[] = ra_page_layout();
  return $classes;
}
add_filter( 'body_class', 'ra_layout_body_class', 5 );

 /**
  * Default Widget Area Arguments
  *
  * @param array $args
  * @return array $args
  */
 function ra_widget_arra_args( $args = array() ) {

 	$defaults = array(
 		'name'          => '',
 		'id'            => '',
 		'description'   => '',
 		'before_widget' => '<section id="%1$s" class="widget %2$s">',
 		'after_widget'  => '</section>',
 		'before_title'  => '<h3 class="widget-title">',
 		'after_title'   => '</h3>',
 	);
 	$args = wp_parse_args( $args, $defaults );

 	if( !empty( $args['name'] ) && empty( $args['id'] ) )
 		$args['id'] = sanitize_title_with_dashes( $args['name'] );

 	return $args;

 }

 /**
  * Page Layout
  *
  */
 function ra_page_layout() {

 	$available_layouts = array( 'full-width-content', 'content-sidebar', 'sidebar-content' );
 	$layout = 'full-width-content';

 	$layout = apply_filters( 'ra_page_layout', $layout );
 	$layout = in_array( $layout, $available_layouts ) ? $layout : $available_layouts[0];

 	return sanitize_title_with_dashes( $layout );
 }

 /**
  * Return Full Width Content
  * used when filtering 'ra_page_layout'
  */
 function ra_return_full_width_content() {
 	return 'full-width-content';
 }

 /**
  * Return Content Sidebar
  * used when filtering 'ra_page_layout'
  */
 function ra_return_content_sidebar() {
 	return 'content-sidebar';
 }

 /**
  * Return Sidebar Content
  * used when filtering 'ra_page_layout'
  */
 function ra_return_sidebar_content() {
 	return 'sidebar-content';
 }
