<?php
/**
 * Thank you.
 *
 * @package Mallorca
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="mallorca-thankyou">
	<?php if ( $order ) : ?>
		<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>
		<?php if ( $order->has_status( 'failed' ) ) : ?>
			<h1><?php esc_html_e( 'No se pudo completar el pedido.', 'mallorca' ); ?></h1>
			<p><?php esc_html_e( 'Inténtalo de nuevo o elige otro método de pago.', 'mallorca' ); ?></p>
			<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"><?php esc_html_e( 'Pagar de nuevo', 'mallorca' ); ?></a>
		<?php else : ?>
			<p class="mallorca-kicker"><?php esc_html_e( 'Pedido recibido', 'mallorca' ); ?></p>
			<h1><?php esc_html_e( 'Gracias por tu pedido.', 'mallorca' ); ?></h1>
			<ul class="mallorca-thankyou__meta">
				<li><span><?php esc_html_e( 'Número', 'mallorca' ); ?></span> <?php echo esc_html( $order->get_order_number() ); ?></li>
				<li><span><?php esc_html_e( 'Fecha', 'mallorca' ); ?></span> <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></li>
				<li><span><?php esc_html_e( 'Total', 'mallorca' ); ?></span> <?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></li>
				<li><span><?php esc_html_e( 'Pago', 'mallorca' ); ?></span> <?php echo wp_kses_post( $order->get_payment_method_title() ); ?></li>
			</ul>
			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
			<div class="mallorca-hero__actions">
				<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( mallorca_shop_url() ); ?>"><?php esc_html_e( 'Seguir explorando', 'mallorca' ); ?></a>
				<a class="mallorca-btn mallorca-btn--ghost" href="<?php echo esc_url( $order->get_view_order_url() ); ?>"><?php esc_html_e( 'Ver mi pedido', 'mallorca' ); ?></a>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<h1><?php esc_html_e( 'Gracias por tu pedido.', 'mallorca' ); ?></h1>
	<?php endif; ?>
</div>
