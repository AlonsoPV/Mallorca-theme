<?php
/**
 * Product archive.
 *
 * @package Mallorca
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>
<header class="mallorca-shop-head mallorca-container">
	<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) : ?>
		<div class="mallorca-breadcrumb"><?php woocommerce_breadcrumb(); ?></div>
	<?php endif; ?>
	<h1><?php echo esc_html( woocommerce_page_title( false ) ? woocommerce_page_title( false ) : __( 'Nuestra pastelería', 'mallorca' ) ); ?></h1>
</header>
<?php
do_action( 'woocommerce_before_main_content' );

if ( woocommerce_product_loop() ) {
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
} else {
	echo '<div class="mallorca-empty mallorca-empty--page"><p>' . esc_html__( 'No hay piezas con esos filtros.', 'mallorca' ) . '</p>';
	echo '<a class="mallorca-btn mallorca-btn--solid" href="' . esc_url( mallorca_shop_url() ) . '">' . esc_html__( 'Ver todo', 'mallorca' ) . '</a></div>';
	do_action( 'woocommerce_no_products_found' );
}

do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
