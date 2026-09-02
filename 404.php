<?php
/**
 * 404.
 *
 * @package Mallorca
 */

get_header();
?>
<main id="primary" class="mallorca-main mallorca-container">
	<div class="mallorca-empty mallorca-empty--page">
		<p class="mallorca-kicker">404</p>
		<h1><?php esc_html_e( 'Esta mesa no existe.', 'mallorca' ); ?></h1>
		<p><?php esc_html_e( 'La página se ha quedado en el horno. Vuelve al inicio o entra a la pastelería.', 'mallorca' ); ?></p>
		<div class="mallorca-hero__actions">
			<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'mallorca' ); ?></a>
			<a class="mallorca-btn mallorca-btn--ghost" href="<?php echo esc_url( mallorca_shop_url() ); ?>"><?php esc_html_e( 'Tienda', 'mallorca' ); ?></a>
		</div>
	</div>
</main>
<?php
get_footer();
