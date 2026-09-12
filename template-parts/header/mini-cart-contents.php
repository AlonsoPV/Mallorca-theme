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
		<div class="mallorca-empty mallorca-empty--mini">
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
				$permalink = $product->is_visible() ? $product->get_permalink( $cart_item ) : '';
				?>
				<li class="mallorca-mini-cart__item">
					<div class="mallorca-mini-cart__thumb">
						<?php if ( $permalink ) : ?>
							<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
								<?php echo $product->get_image( 'woocommerce_gallery_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php else : ?>
							<?php echo $product->get_image( 'woocommerce_gallery_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php endif; ?>
					</div>
					<div class="mallorca-mini-cart__info">
						<div class="mallorca-mini-cart__info-top">
							<?php if ( $permalink ) : ?>
								<a class="mallorca-mini-cart__name" href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
							<?php else : ?>
								<span class="mallorca-mini-cart__name"><?php echo esc_html( $product->get_name() ); ?></span>
							<?php endif; ?>
							<?php
							echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								'woocommerce_cart_item_remove_link',
								sprintf(
									'<a role="button" href="%s" class="mallorca-mini-cart__remove remove" aria-label="%s">&times;</a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_attr( sprintf( __( 'Eliminar %s', 'mallorca' ), wp_strip_all_tags( $product->get_name() ) ) )
								),
								$cart_item_key
							);
							?>
						</div>
						<p class="mallorca-mini-cart__meta">
							<?php echo esc_html( (string) $cart_item['quantity'] ); ?>
							<span aria-hidden="true">×</span>
							<?php echo wp_kses_post( WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] ) ); ?>
						</p>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="mallorca-mini-cart__foot">
			<p class="mallorca-mini-cart__subtotal">
				<span><?php esc_html_e( 'Subtotal', 'mallorca' ); ?></span>
				<strong><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></strong>
			</p>
			<a class="mallorca-btn mallorca-btn--solid mallorca-mini-cart__checkout" href="<?php echo esc_url( mallorca_checkout_url() ); ?>"><?php esc_html_e( 'Finalizar pedido', 'mallorca' ); ?></a>
			<a class="mallorca-mini-cart__view" href="<?php echo esc_url( mallorca_cart_url() ); ?>"><?php esc_html_e( 'Ver carrito completo', 'mallorca' ); ?></a>
		</div>
	<?php endif; ?>
</div>
