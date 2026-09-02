<?php
/**
 * Product archive.
 *
 * @package Mallorca
 */

defined( 'ABSPATH' ) || exit;

get_header();

$shop_id = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0;
if ( $shop_id && mallorca_is_elementor_page( $shop_id ) && function_exists( 'mallorca_elementor_content' ) ) {
	echo '<main id="primary" class="mallorca-main mallorca-main--elementor mallorca-woo">';
	mallorca_elementor_content( $shop_id );
	echo '</main>';
} else {
	do_action( 'woocommerce_before_main_content' );
	get_template_part( 'template-parts/woocommerce/shop' );
	do_action( 'woocommerce_after_main_content' );
}

get_footer();
