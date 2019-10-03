<?php
/**
 * Sidebar
 *
 * @package      RA Starter
 * @author       Rotsen Mark Acob
 * @since        1.0.0
 * @license      GPL-2.0+
**/

if ( ! function_exists( 'ra_page_layout' ) )
	return;

$layout = ra_page_layout();
if ( ! in_array( $layout, array( 'content-sidebar', 'sidebar-content' ) ) )
	return;

$sidebar = apply_filters( 'ra_sidebar', 'primary-sidebar' );
$display = is_active_sidebar( $sidebar );
if ( ! apply_filters( 'ra_display_sidebar', $display ) )
	return;

tha_sidebars_before();

echo '<aside class="sidebar-primary" role="complementary">';
	tha_sidebar_top();
	if ( is_active_sidebar( $sidebar ) )
		dynamic_sidebar( $sidebar );
	tha_sidebar_bottom();
echo '</aside>';

tha_sidebars_after();
