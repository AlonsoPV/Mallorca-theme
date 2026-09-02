<?php
/**
 * Empty cart.
 *
 * @package Mallorca
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="mallorca-empty mallorca-empty--page">
	<h1><?php esc_html_e( 'Tu mesa aún está vacía.', 'mallorca' ); ?></h1>
	<p><?php esc_html_e( 'Añade una pieza del obrador para continuar.', 'mallorca' ); ?></p>
	<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', mallorca_shop_url() ) ); ?>">
		<?php esc_html_e( 'Explorar la pastelería', 'mallorca' ); ?>
	</a>
</div>
