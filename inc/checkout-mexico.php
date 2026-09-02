<?php
/**
 * Checkout fields prepared for Mexico.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Colonia and regroup fields.
 *
 * @param array $fields Fields.
 * @return array
 */
function mallorca_address_fields( $fields ) {
	if ( apply_filters( 'mallorca_disable_mx_checkout', false ) ) {
		return $fields;
	}

	$fields['billing_colonia'] = array(
		'label'    => __( 'Colonia', 'mallorca' ),
		'required' => false,
		'class'    => array( 'form-row-wide' ),
		'priority' => 65,
	);

	if ( isset( $fields['billing_state'] ) ) {
		$fields['billing_state']['label'] = __( 'Estado', 'mallorca' );
	}
	if ( isset( $fields['billing_city'] ) ) {
		$fields['billing_city']['label'] = __( 'Ciudad', 'mallorca' );
	}
	if ( isset( $fields['billing_postcode'] ) ) {
		$fields['billing_postcode']['label']    = __( 'Código postal', 'mallorca' );
		$fields['billing_postcode']['priority'] = 60;
	}

	return $fields;
}
add_filter( 'woocommerce_billing_fields', 'mallorca_address_fields' );

/**
 * Shipping colonia.
 *
 * @param array $fields Fields.
 * @return array
 */
function mallorca_shipping_fields( $fields ) {
	if ( apply_filters( 'mallorca_disable_mx_checkout', false ) ) {
		return $fields;
	}

	$fields['shipping_colonia'] = array(
		'label'    => __( 'Colonia', 'mallorca' ),
		'required' => false,
		'class'    => array( 'form-row-wide' ),
		'priority' => 65,
	);
	return $fields;
}
add_filter( 'woocommerce_shipping_fields', 'mallorca_shipping_fields' );

/**
 * Default country MX.
 *
 * @param array $fields Fields.
 * @return array
 */
function mallorca_default_address_fields( $fields ) {
	if ( isset( $fields['country'] ) ) {
		$fields['country']['priority'] = 40;
	}
	return $fields;
}
add_filter( 'woocommerce_default_address_fields', 'mallorca_default_address_fields' );

add_filter(
	'woocommerce_checkout_fields',
	static function ( $fields ) {
		if ( isset( $fields['billing']['billing_phone'] ) ) {
			$fields['billing']['billing_phone']['required'] = true;
			$fields['billing']['billing_phone']['priority'] = 25;
		}
		if ( isset( $fields['billing']['billing_email'] ) ) {
			$fields['billing']['billing_email']['priority'] = 22;
		}
		return $fields;
	}
);
