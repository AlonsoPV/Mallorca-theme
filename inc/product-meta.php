<?php
/**
 * Bakery product meta (no ACF).
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product extra fields.
 *
 * @return array
 */
function mallorca_product_fields() {
	return array(
		'servings'      => __( 'Porciones / tamaño', 'mallorca' ),
		'weight'        => __( 'Peso', 'mallorca' ),
		'ingredients'   => __( 'Ingredientes', 'mallorca' ),
		'allergens'     => __( 'Alérgenos', 'mallorca' ),
		'conservation'  => __( 'Conservación', 'mallorca' ),
		'delivery_note' => __( 'Nota de entrega / recolección', 'mallorca' ),
	);
}

/**
 * Product metabox.
 */
function mallorca_product_metaboxes() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	add_meta_box(
		'mallorca_product_bakery',
		__( 'Ficha de pastelería', 'mallorca' ),
		'mallorca_product_metabox_html',
		'product',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'mallorca_product_metaboxes' );

/**
 * Metabox HTML.
 *
 * @param WP_Post $post Post.
 */
function mallorca_product_metabox_html( $post ) {
	wp_nonce_field( 'mallorca_product_save', 'mallorca_product_nonce' );
	echo '<p>' . esc_html__( 'Campos opcionales para tartas, porciones y alérgenos. Compatible con add-ons de WooCommerce.', 'mallorca' ) . '</p>';
	foreach ( mallorca_product_fields() as $key => $label ) {
		$value = get_post_meta( $post->ID, '_mallorca_' . $key, true );
		echo '<p><label for="mallorca_p_' . esc_attr( $key ) . '"><strong>' . esc_html( $label ) . '</strong></label><br />';
		if ( in_array( $key, array( 'ingredients', 'allergens', 'conservation', 'delivery_note' ), true ) ) {
			echo '<textarea class="widefat" rows="3" id="mallorca_p_' . esc_attr( $key ) . '" name="mallorca_p_' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea>';
		} else {
			echo '<input class="widefat" type="text" id="mallorca_p_' . esc_attr( $key ) . '" name="mallorca_p_' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" />';
		}
		echo '</p>';
	}
}

/**
 * Save product meta.
 *
 * @param int $post_id Post ID.
 */
function mallorca_save_product_meta( $post_id ) {
	if ( ! isset( $_POST['mallorca_product_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mallorca_product_nonce'] ) ), 'mallorca_product_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array_keys( mallorca_product_fields() ) as $key ) {
		if ( ! isset( $_POST[ 'mallorca_p_' . $key ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ 'mallorca_p_' . $key ] );
		if ( in_array( $key, array( 'ingredients', 'allergens', 'conservation', 'delivery_note' ), true ) ) {
			update_post_meta( $post_id, '_mallorca_' . $key, sanitize_textarea_field( $raw ) );
		} else {
			update_post_meta( $post_id, '_mallorca_' . $key, sanitize_text_field( $raw ) );
		}
	}
}
add_action( 'save_post_product', 'mallorca_save_product_meta' );
