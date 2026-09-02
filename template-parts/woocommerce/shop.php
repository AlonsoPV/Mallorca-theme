<?php
/**
 * Shop catalog (archive or Elementor widget).
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	echo '<p class="mallorca-empty">' . esc_html__( 'Activa WooCommerce para mostrar la tienda.', 'mallorca' ) . '</p>';
	return;
}

$use_main = ( is_shop() || is_product_taxonomy() ) && have_posts();
$custom   = null;

if ( ! $use_main ) {
	$custom = new WP_Query(
		array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => (int) apply_filters( 'loop_shop_per_page', 12 ),
		)
	);
}
?>
<section class="mallorca-shop">
	<header class="mallorca-shop-head mallorca-container">
		<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) : ?>
			<div class="mallorca-breadcrumb"><?php woocommerce_breadcrumb(); ?></div>
		<?php endif; ?>
		<h1><?php echo esc_html( function_exists( 'woocommerce_page_title' ) && woocommerce_page_title( false ) ? woocommerce_page_title( false ) : __( 'Nuestra pastelería', 'mallorca' ) ); ?></h1>
	</header>
	<?php
	if ( $use_main && woocommerce_product_loop() ) {
		do_action( 'woocommerce_before_shop_loop' );
		woocommerce_product_loop_start();
		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();
				do_action( 'woocommerce_shop_loop' );
				wc_get_template_part( 'content', 'product' );
			}
		}
		woocommerce_product_loop_end();
		do_action( 'woocommerce_after_shop_loop' );
	} elseif ( $custom && $custom->have_posts() ) {
		wc_set_loop_prop( 'total', (int) $custom->found_posts );
		wc_set_loop_prop( 'columns', 4 );
		woocommerce_product_loop_start();
		while ( $custom->have_posts() ) {
			$custom->the_post();
			do_action( 'woocommerce_shop_loop' );
			wc_get_template_part( 'content', 'product' );
		}
		woocommerce_product_loop_end();
		wp_reset_postdata();
	} else {
		echo '<div class="mallorca-empty mallorca-empty--page"><p>' . esc_html__( 'No hay piezas con esos filtros.', 'mallorca' ) . '</p>';
		echo '<a class="mallorca-btn mallorca-btn--solid" href="' . esc_url( mallorca_shop_url() ) . '">' . esc_html__( 'Ver todo', 'mallorca' ) . '</a></div>';
	}
	?>
</section>
