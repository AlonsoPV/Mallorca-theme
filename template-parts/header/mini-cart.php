<?php
/**
 * Mini cart drawer.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="mallorca-mini-cart" class="mallorca-mini-cart" hidden>
	<div class="mallorca-mini-cart__panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Carrito', 'mallorca' ); ?>">
		<div class="mallorca-mini-cart__top">
			<p><?php esc_html_e( 'Tu pedido', 'mallorca' ); ?></p>
			<button class="mallorca-icon-btn js-mallorca-close-cart" type="button" aria-label="<?php esc_attr_e( 'Cerrar carrito', 'mallorca' ); ?>">
				<?php echo mallorca_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		</div>
		<?php get_template_part( 'template-parts/header/mini-cart-contents' ); ?>
	</div>
</div>
