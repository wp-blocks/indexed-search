<?php

/**
 * Registers a live search endpoint for the plugin.
 */
function register_live_search_endpoint() {
	register_rest_route(
		'vsge/v2',
		'/live-search',
		array(
			'methods'             => 'POST',
			'callback'            => 's_live_search',
			'permission_callback' => '__return_true',
		)
	);
}

/**
 * Generates search results for a live search query.
 *
 * @param WP_REST_Request $request The REST request object containing the search query.
 * @throws Exception If an error occurs during the search process.
 * @return WP_REST_Response The search results in JSON format.
 */
function s_live_search( WP_REST_Request $request ) {
	$query_string = sanitize_text_field( $request->get_param( 'query' ) );

	// Generate a unique key for the transient based on the search parameters
	$cache_key = 'custom_search_' . md5( $query_string );

	// Try to retrieve the search results from the transient cache
	$results = get_transient( $cache_key );

	if ( false === $results ) {

		// Perform your search logic and fetch data
		$args  = array(
			'post_type'      => array( 'product', 'post' ),
			's'              => $query_string,
			'posts_per_page' => 4,
		);
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			ob_start();
			while ( $query->have_posts() ) {
				$query->the_post();

				global $post;

				echo $post->ID;

				echo '<div class="post-title">' . get_the_title() . '</div>';

			}
			$results = ob_get_clean();
			wp_reset_postdata();
		} else {
			$results = '';
		}
	}

	// Save the search results to the transient cache for 1 minute (60 seconds)
	set_transient( $cache_key, $results, 60 );

	// Return the results as JSON
	return rest_ensure_response($results );
}
