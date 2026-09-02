<?php
/**
 * Single product layout (theme or Elementor widget).
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	echo '<p class="mallorca-empty">' . esc_html__( 'Activa WooCommerce para mostrar el producto.', 'mallorca' ) . '</p>';
	return;
}

global $product, $post;

$restore = false;
if ( ! $product instanceof WC_Product ) {
	$sample = wc_get_products(
		array(
			'limit'  => 1,
			'status' => 'publish',
		)
	);
	if ( empty( $sample ) ) {
		echo '<p class="mallorca-empty">' . esc_html__( 'Añade un producto para previsualizar esta plantilla.', 'mallorca' ) . '</p>';
		return;
	}
	$product = $sample[0];
	$post    = get_post( $product->get_id() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	setup_postdata( $post );
	$restore = true;
}

wc_setup_product_data( $post );
do_action( 'woocommerce_before_single_product' );
if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	if ( $restore ) {
		wp_reset_postdata();
	}
	return;
}
?>
<div id="product-<?php echo esc_attr( (string) $product->get_id() ); ?>" <?php wc_product_class( 'mallorca-single', $product->get_id() ); ?>>
	<div class="mallorca-single__grid">
		<div class="mallorca-single__gallery">
			<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
		</div>
		<div id="mallorca-add-to-cart" class="mallorca-single__summary summary entry-summary">
			<?php if ( function_exists( 'woocommerce_breadcrumb' ) ) : ?>
				<div class="mallorca-breadcrumb"><?php woocommerce_breadcrumb(); ?></div>
			<?php endif; ?>
			<?php do_action( 'woocommerce_single_product_summary' ); ?>
		</div>
	</div>
	<div class="mallorca-single__after">
		<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
	</div>
</div>
<?php
do_action( 'woocommerce_after_single_product' );
if ( $restore ) {
	wp_reset_postdata();
}
