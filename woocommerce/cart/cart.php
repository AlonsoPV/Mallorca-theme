<?php
/**
 * Cart.
 *
 * @package Mallorca
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>
<form class="woocommerce-cart-form mallorca-cart" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<div class="mallorca-cart__layout">
		<div class="mallorca-cart__items">
			<h1 class="mallorca-cart__title"><?php esc_html_e( 'Tu pedido', 'mallorca' ); ?></h1>
			<?php if ( WC()->cart->is_empty() ) : ?>
				<div class="mallorca-empty mallorca-empty--inline">
					<p><?php esc_html_e( 'El carrito está vacío.', 'mallorca' ); ?></p>
					<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( mallorca_shop_url() ); ?>"><?php esc_html_e( 'Seguir explorando', 'mallorca' ); ?></a>
				</div>
			<?php else : ?>
				<div class="mallorca-cart-lines woocommerce-cart-form__contents">
					<?php
					do_action( 'woocommerce_before_cart_contents' );
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
						if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 ) {
							continue;
						}
						$permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<article class="mallorca-cart-line woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
							<div class="mallorca-cart-line__media product-thumbnail">
								<?php
								if ( $permalink ) {
									echo '<a href="' . esc_url( $permalink ) . '">';
								}
								echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail' ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								if ( $permalink ) {
									echo '</a>';
								}
								?>
							</div>
							<div class="mallorca-cart-line__main product-name">
								<?php
								if ( $permalink ) {
									echo '<a class="mallorca-cart-line__title" href="' . esc_url( $permalink ) . '">' . wp_kses_post( $_product->get_name() ) . '</a>';
								} else {
									echo '<span class="mallorca-cart-line__title">' . wp_kses_post( $_product->get_name() ) . '</span>';
								}
								echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</div>
							<div class="mallorca-cart-line__qty product-quantity">
								<?php
								if ( $_product->is_sold_individually() ) {
									$min = 1;
									$max = 1;
								} else {
									$min = 0;
									$max = $_product->get_max_purchase_quantity();
								}
								echo woocommerce_quantity_input( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									array(
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $max,
										'min_value'    => $min,
										'product_name' => $_product->get_name(),
									),
									$_product,
									false
								);
								?>
							</div>
							<div class="mallorca-cart-line__subtotal product-subtotal">
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<div class="mallorca-cart-line__remove product-remove">
								<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a role="button" href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span aria-hidden="true">&times;</span><span class="screen-reader-text">%s</span></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_attr( sprintf( __( 'Eliminar %s', 'mallorca' ), wp_strip_all_tags( $_product->get_name() ) ) ),
										esc_attr( (string) $product_id ),
										esc_attr( $_product->get_sku() ),
										esc_html__( 'Eliminar', 'mallorca' )
									),
									$cart_item_key
								);
								?>
							</div>
						</article>
						<?php
					}
					do_action( 'woocommerce_cart_contents' );
					?>
				</div>
				<div class="mallorca-cart__actions actions">
					<button type="submit" class="mallorca-cart__update" name="update_cart" value="<?php esc_attr_e( 'Actualizar', 'mallorca' ); ?>"><?php esc_html_e( 'Actualizar cantidades', 'mallorca' ); ?></button>
					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</div>
				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
			<?php endif; ?>
		</div>
		<?php if ( ! WC()->cart->is_empty() ) : ?>
			<aside class="mallorca-cart__summary cart-collaterals">
				<?php do_action( 'woocommerce_cart_collaterals' ); ?>
				<details class="mallorca-coupon">
					<summary><?php esc_html_e( '¿Tienes un cupón?', 'mallorca' ); ?></summary>
					<?php if ( wc_coupons_enabled() ) : ?>
						<div class="coupon">
							<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Cupón', 'mallorca' ); ?></label>
							<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Código', 'mallorca' ); ?>" />
							<button type="submit" class="mallorca-btn mallorca-btn--ghost" name="apply_coupon" value="<?php esc_attr_e( 'Aplicar cupón', 'mallorca' ); ?>"><?php esc_html_e( 'Aplicar', 'mallorca' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php endif; ?>
				</details>
			</aside>
		<?php endif; ?>
	</div>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>
<?php do_action( 'woocommerce_after_cart' ); ?>
