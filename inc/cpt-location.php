<?php
/**
 * Custom Post Type: sucursales.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register locations CPT.
 */
function mallorca_register_location_cpt() {
	register_post_type(
		'mallorca_location',
		array(
			'labels' => array(
				'name'               => __( 'Sucursales', 'mallorca' ),
				'singular_name'      => __( 'Sucursal', 'mallorca' ),
				'add_new'            => __( 'Añadir sucursal', 'mallorca' ),
				'add_new_item'       => __( 'Añadir sucursal', 'mallorca' ),
				'edit_item'          => __( 'Editar sucursal', 'mallorca' ),
				'new_item'           => __( 'Nueva sucursal', 'mallorca' ),
				'view_item'          => __( 'Ver sucursal', 'mallorca' ),
				'search_items'       => __( 'Buscar sucursales', 'mallorca' ),
				'not_found'          => __( 'No hay sucursales', 'mallorca' ),
				'not_found_in_trash' => __( 'No hay sucursales en la papelera', 'mallorca' ),
				'all_items'          => __( 'Todas las sucursales', 'mallorca' ),
				'menu_name'          => __( 'Sucursales', 'mallorca' ),
			),
			'public'             => true,
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'sucursales' ),
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-location',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		)
	);
}
add_action( 'init', 'mallorca_register_location_cpt' );

/**
 * Location meta keys.
 *
 * @return array
 */
function mallorca_location_fields() {
	return array(
		'location_name'     => array( 'label' => __( 'Nombre visible', 'mallorca' ), 'type' => 'text' ),
		'address'           => array( 'label' => __( 'Dirección', 'mallorca' ), 'type' => 'textarea' ),
		'google_maps_url'   => array( 'label' => __( 'URL de Google Maps', 'mallorca' ), 'type' => 'url' ),
		'phone'             => array( 'label' => __( 'Teléfono', 'mallorca' ), 'type' => 'text' ),
		'whatsapp'          => array( 'label' => __( 'WhatsApp', 'mallorca' ), 'type' => 'text' ),
		'reservation_url'   => array( 'label' => __( 'Enlace para reservar', 'mallorca' ), 'type' => 'url' ),
		'order_url'         => array( 'label' => __( 'Enlace para pedir', 'mallorca' ), 'type' => 'url' ),
		'schedule'          => array( 'label' => __( 'Horario', 'mallorca' ), 'type' => 'textarea' ),
		'email'             => array( 'label' => __( 'Correo', 'mallorca' ), 'type' => 'email' ),
	);
}

/**
 * Metabox.
 */
function mallorca_location_metaboxes() {
	add_meta_box(
		'mallorca_location_details',
		__( 'Datos de la sucursal', 'mallorca' ),
		'mallorca_location_metabox_html',
		'mallorca_location',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'mallorca_location_metaboxes' );

/**
 * Metabox HTML.
 *
 * @param WP_Post $post Post.
 */
function mallorca_location_metabox_html( $post ) {
	wp_nonce_field( 'mallorca_location_save', 'mallorca_location_nonce' );

	foreach ( mallorca_location_fields() as $key => $field ) {
		$value = get_post_meta( $post->ID, '_mallorca_' . $key, true );
		echo '<p class="mallorca-meta-field">';
		echo '<label for="mallorca_' . esc_attr( $key ) . '"><strong>' . esc_html( $field['label'] ) . '</strong></label><br />';
		if ( 'textarea' === $field['type'] ) {
			echo '<textarea class="widefat" rows="3" id="mallorca_' . esc_attr( $key ) . '" name="mallorca_' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea>';
		} else {
			echo '<input class="widefat" type="' . esc_attr( $field['type'] ) . '" id="mallorca_' . esc_attr( $key ) . '" name="mallorca_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" />';
		}
		echo '</p>';
	}
}

/**
 * Save location meta.
 *
 * @param int $post_id Post ID.
 */
function mallorca_save_location_meta( $post_id ) {
	if ( ! isset( $_POST['mallorca_location_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mallorca_location_nonce'] ) ), 'mallorca_location_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( mallorca_location_fields() as $key => $field ) {
		if ( ! isset( $_POST[ 'mallorca_' . $key ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ 'mallorca_' . $key ] );
		if ( 'url' === $field['type'] ) {
			$value = esc_url_raw( $raw );
		} elseif ( 'email' === $field['type'] ) {
			$value = sanitize_email( $raw );
		} elseif ( 'textarea' === $field['type'] ) {
			$value = sanitize_textarea_field( $raw );
		} else {
			$value = sanitize_text_field( $raw );
		}
		update_post_meta( $post_id, '_mallorca_' . $key, $value );
	}
}
add_action( 'save_post_mallorca_location', 'mallorca_save_location_meta' );

/**
 * Expose location meta in REST for Elementor dynamic tags.
 *
 * @param WP_REST_Response $response Response.
 * @param WP_Post          $post     Post.
 * @return WP_REST_Response
 */
function mallorca_location_rest_fields( $response, $post ) {
	$data = $response->get_data();
	foreach ( array_keys( mallorca_location_fields() ) as $key ) {
		$data[ $key ] = get_post_meta( $post->ID, '_mallorca_' . $key, true );
	}
	$response->set_data( $data );
	return $response;
}
add_filter( 'rest_prepare_mallorca_location', 'mallorca_location_rest_fields', 10, 2 );
