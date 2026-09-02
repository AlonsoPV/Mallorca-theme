<?php
/**
 * Mini cart contents (AJAX fragment).
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$has_cart = function_exists( 'WC' ) && WC()->cart;
?>
<div class="js-mallorca-mini-cart-body mallorca-mini-cart__body">
	<?php if ( ! $has_cart || WC()->cart->is_empty() ) : ?>
		<div class="mallorca-empty">
			<p><?php esc_html_e( 'Tu mesa aún está vacía.', 'mallorca' ); ?></p>
			<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( mallorca_shop_url() ); ?>"><?php esc_html_e( 'Explorar la pastelería', 'mallorca' ); ?></a>
		</div>
	<?php else : ?>
		<ul class="mallorca-mini-cart__items">
			<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>
				<?php
				$product = $cart_item['data'];
				if ( ! $product || ! $product->exists() ) {
					continue;
				}
				?>
				<li class="mallorca-mini-cart__item">
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
						<?php echo $product->get_image( 'woocommerce_gallery_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
					<div>
						<a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
						<p><?php echo esc_html( $cart_item['quantity'] ); ?> × <?php echo wp_kses_post( WC()->cart->get_product_price( $product ) ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="mallorca-mini-cart__foot">
			<p class="mallorca-mini-cart__subtotal">
				<span><?php esc_html_e( 'Subtotal', 'mallorca' ); ?></span>
				<strong><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></strong>
			</p>
			<a class="mallorca-btn mallorca-btn--ghost" href="<?php echo esc_url( mallorca_cart_url() ); ?>"><?php esc_html_e( 'Ver carrito', 'mallorca' ); ?></a>
			<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( mallorca_checkout_url() ); ?>"><?php esc_html_e( 'Finalizar pedido', 'mallorca' ); ?></a>
		</div>
	<?php endif; ?>
</div>
