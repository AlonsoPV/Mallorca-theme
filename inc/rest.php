<?php
/**
 * REST search for overlay.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register routes.
 */
function mallorca_register_rest() {
	register_rest_route(
		'mallorca/v1',
		'/search',
		array(
			'methods'             => 'GET',
			'callback'            => 'mallorca_rest_search',
			'permission_callback' => '__return_true',
			'args'                => array(
				'q' => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'mallorca_register_rest' );

/**
 * Search products and categories.
 *
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response
 */
function mallorca_rest_search( $request ) {
	$q       = $request->get_param( 'q' );
	$results = array();

	if ( class_exists( 'WooCommerce' ) ) {
		$products = wc_get_products(
			array(
				'status' => 'publish',
				'limit'  => 8,
				's'      => $q,
			)
		);
		foreach ( $products as $product ) {
			$results[] = array(
				'title' => $product->get_name(),
				'url'   => $product->get_permalink(),
				'price' => wp_strip_all_tags( $product->get_price_html() ),
				'image' => wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_gallery_thumbnail' ),
			);
		}

		$terms = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
				'search'     => $q,
				'number'     => 4,
			)
		);
		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$results[] = array(
					'title' => $term->name,
					'url'   => get_term_link( $term ),
					'price' => __( 'Categoría', 'mallorca' ),
					'image' => '',
				);
			}
		}
	} else {
		$query = new WP_Query(
			array(
				's'              => $q,
				'posts_per_page' => 8,
				'post_status'    => 'publish',
			)
		);
		foreach ( $query->posts as $post ) {
			$results[] = array(
				'title' => get_the_title( $post ),
				'url'   => get_permalink( $post ),
				'price' => '',
				'image' => get_the_post_thumbnail_url( $post, 'thumbnail' ),
			);
		}
	}

	return rest_ensure_response( $results );
}

/**
 * Newsletter form (handoff hook, no mailing list in the theme).
 */
function mallorca_handle_newsletter() {
	if ( ! isset( $_POST['mallorca_newsletter_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mallorca_newsletter_nonce'] ) ), 'mallorca_newsletter' ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	if ( $email ) {
		do_action( 'mallorca_newsletter_subscribe', $email );
	}

	wp_safe_redirect( add_query_arg( 'mallorca_subscribed', '1', wp_get_referer() ? wp_get_referer() : home_url( '/' ) ) );
	exit;
}
add_action( 'admin_post_mallorca_newsletter', 'mallorca_handle_newsletter' );
add_action( 'admin_post_nopriv_mallorca_newsletter', 'mallorca_handle_newsletter' );

add_filter(
	'woocommerce_page_title',
	static function ( $title ) {
		if ( function_exists( 'is_shop' ) && is_shop() && ! is_search() ) {
			return __( 'Nuestra pastelería', 'mallorca' );
		}
		return $title;
	}
);
