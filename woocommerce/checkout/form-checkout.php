<?php
/**
 * Checkout form.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'Debes iniciar sesión para pagar.', 'mallorca' ) ) );
	return;
}
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout mallorca-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<p class="mallorca-checkout-secure"><?php esc_html_e( 'Compra segura', 'mallorca' ); ?></p>
	<div class="mallorca-checkout__intro">
		<h1 class="mallorca-checkout__title"><?php esc_html_e( 'Finalizar pedido', 'mallorca' ); ?></h1>
		<p class="mallorca-checkout__lead"><?php esc_html_e( 'Revisa tus datos y confirma tu mesa.', 'mallorca' ); ?></p>
	</div>
	<div class="mallorca-checkout__layout">
		<div class="mallorca-checkout__form">
			<?php if ( $checkout->get_checkout_fields() ) : ?>
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				<section class="mallorca-checkout__block">
					<h2><?php esc_html_e( 'Contacto', 'mallorca' ); ?></h2>
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
				</section>
				<section class="mallorca-checkout__block">
					<h2><?php esc_html_e( 'Entrega', 'mallorca' ); ?></h2>
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</section>
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
			<?php endif; ?>
		</div>
		<aside class="mallorca-checkout__summary">
			<h2><?php esc_html_e( 'Tu pedido', 'mallorca' ); ?></h2>
			<p class="mallorca-kicker"><?php esc_html_e( 'Pago', 'mallorca' ); ?></p>
			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>
			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
		</aside>
	</div>
</form>
<?php
do_action( 'woocommerce_after_checkout_form', $checkout );
