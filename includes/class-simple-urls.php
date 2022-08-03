<?php
/**
 * Really Simple URLs file.
 *
 * @package really-simple-urls
 */

/**
 * Really Simple URLs class.
 */
class Really_Simple_Urls {

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'template_redirect', array( $this, 'count_and_redirect' ) );

	}

	/**
	 * Load textdomain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'really-simple-urls', false, REALLY_SIMPLE_URLS_DIR . '/languages' );
	}

	/**
	 * Register Post Type.
	 */
	public function register_post_type() {

		$slug = 'surl';

		$rewrite_slug_default = 'go';

		$labels = array(
			'name'               => __( 'Really Simple URLs', 'really-simple-urls' ),
			'singular_name'      => __( 'URL', 'really-simple-urls' ),
			'add_new'            => __( 'Add New', 'really-simple-urls' ),
			'add_new_item'       => __( 'Add New URL', 'really-simple-urls' ),
			'edit'               => __( 'Edit', 'really-simple-urls' ),
			'edit_item'          => __( 'Edit URL', 'really-simple-urls' ),
			'new_item'           => __( 'New URL', 'really-simple-urls' ),
			'view'               => __( 'View URL', 'really-simple-urls' ),
			'view_item'          => __( 'View URL', 'really-simple-urls' ),
			'search_items'       => __( 'Search URL', 'really-simple-urls' ),
			'not_found'          => __( 'No URLs found', 'really-simple-urls' ),
			'not_found_in_trash' => __( 'No URLs found in Trash', 'really-simple-urls' ),
			'messages'           => array(
				0  => '', // Unused. Messages start at index 1.
				/* translators: %s: link for the update */
				1  => __( 'URL updated. <a href="%s">View URL</a>', 'really-simple-urls' ),
				2  => __( 'Custom field updated.', 'really-simple-urls' ),
				3  => __( 'Custom field deleted.', 'really-simple-urls' ),
				4  => __( 'URL updated.', 'really-simple-urls' ),
				/* translators: %s: date and time of the revision */
				5  => isset( $_GET['revision'] ) ? sprintf( __( 'Post restored to revision from %s', 'really-simple-urls' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore
				/* translators: %s: URL to view */
				6  => __( 'URL updated. <a href="%s">View URL</a>', 'really-simple-urls' ),
				7  => __( 'URL saved.', 'really-simple-urls' ),
				8  => __( 'URL submitted.', 'really-simple-urls' ),
				9  => __( 'URL scheduled', 'really-simple-urls' ),
				10 => __( 'URL draft updated.', 'really-simple-urls' ),
			),
		);

		$labels = apply_filters( 'really_simple_urls_cpt_labels', $labels );

		$rewrite_slug = apply_filters( 'really_simple_urls_slug', $rewrite_slug_default );

		$rewrite_slug = sanitize_title( $rewrite_slug, $rewrite_slug_default );

		// Ref: https://developer.wordpress.org/reference/functions/add_post_type_support/.
		$supports_array = apply_filters( 'really_simple_urls_post_type_supports', array( 'title' ) );

		// Ref: https://developer.wordpress.org/reference/functions/register_post_type/.
		register_post_type(
			$slug,
			array(
				'labels'              => $labels,
				'public'              => true,
				'exclude_from_search' => apply_filters( 'really_simple_urls_exclude_from_search', true ),
				'show_ui'             => true,
				'query_var'           => true,
				'menu_position'       => 20,
				'supports'            => $supports_array,
				'rewrite'             => array(
					'slug'       => $rewrite_slug,
					'with_front' => false,
				),
				'show_in_rest'        => true,
			)
		);

	}

	/**
	 * Count and redirect function.
	 */
	public function count_and_redirect() {

		if ( ! is_singular( 'surl' ) ) {
			return;
		}

		global $wp_query;

		// Update the count.
		$count = isset( $wp_query->post->_surl_count ) ? (int) $wp_query->post->_surl_count : 0;
		update_post_meta( $wp_query->post->ID, '_surl_count', $count + 1 );

		// Handle the redirect.
		$redirect = isset( $wp_query->post->ID ) ? get_post_meta( $wp_query->post->ID, '_surl_redirect', true ) : '';

		/**
		 * Filter the redirect URL.
		 *
		 * @since 0.9.5
		 *
		 * @param string  $redirect The URL to redirect to.
		 * @param int  $var The current click count.
		 */
		$redirect = apply_filters( 'really_simple_urls_redirect_url', $redirect, $count );

		/**
		 * Action hook that fires before the redirect.
		 *
		 * @since 0.9.5
		 *
		 * @param string  $redirect The URL to redirect to.
		 * @param int  $var The current click count.
		 */
		do_action( 'really_simple_urls_redirect', $redirect, $count );

		if ( ! empty( $redirect ) ) {
			wp_redirect( esc_url_raw( $redirect ), 301 ); // phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect -- the redirect URL was added by a user with access to the admin and is filterable. Adding to allowed_redirect_hosts does little to improve security here.
			exit;
		} else {
			wp_safe_redirect( home_url(), 302 );
			exit;
		}

	}

}
