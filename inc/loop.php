<?php
/**
 * Loop
 *
 * @package      RA Starter
 * @author       Rotsen Mark Acob
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Default Loop
 *
 */
function ra_default_loop() {

	if ( have_posts() ) :

		tha_content_while_before();

		/* Start the Loop */
		while ( have_posts() ) : the_post();

			tha_entry_before();

			$partial = apply_filters( 'ra_loop_partial', is_singular() ? 'content' : 'archive' );
			$context = apply_filters( 'ra_loop_partial_context', is_search() ? 'search' : get_post_type() );
			get_template_part( 'partials/' . $partial, $context );

			tha_entry_after();

		endwhile;

		tha_content_while_after();

	else :

		tha_entry_before();
		$context = apply_filters( 'ra_empty_loop_partial_context', 'none' );
		get_template_part( 'partials/archive', $context );
		tha_entry_after();

	endif;

}
add_action( 'tha_content_loop', 'ra_default_loop' );

/**
 * Entry Title
 *
 */
function ra_entry_title() {
	echo '<h1 class="entry-title">' . get_the_title() . '</h1>';
}
add_action( 'tha_entry_top', 'ra_entry_title' );

/**
 * Post Comments
 *
 */
function ra_comments() {

	if ( is_single() && ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}

}
add_action( 'tha_content_while_after', 'ra_comments' );
