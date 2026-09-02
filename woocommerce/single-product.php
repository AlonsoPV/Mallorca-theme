<?php
/**
 * Single product.
 *
 * @package Mallorca
 */

defined( 'ABSPATH' ) || exit;

get_header();

$elementor_id = function_exists( 'mallorca_elementor_product_template_id' ) ? mallorca_elementor_product_template_id() : 0;

while ( have_posts() ) :
	the_post();
	if ( $elementor_id && function_exists( 'mallorca_elementor_content' ) ) {
		echo '<main id="primary" class="mallorca-main mallorca-main--elementor mallorca-woo">';
		mallorca_elementor_content( $elementor_id );
		echo '</main>';
	} else {
		do_action( 'woocommerce_before_main_content' );
		get_template_part( 'template-parts/woocommerce/product' );
		do_action( 'woocommerce_after_main_content' );
	}
endwhile;

get_footer();
