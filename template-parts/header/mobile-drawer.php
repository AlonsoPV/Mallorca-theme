<?php
/**
 * Mobile navigation drawer.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="mallorca-drawer" class="mallorca-drawer" hidden>
	<div class="mallorca-drawer__panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menú', 'mallorca' ); ?>">
		<div class="mallorca-drawer__top">
			<a class="mallorca-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>">Mallorca</a>
			<button class="mallorca-icon-btn js-mallorca-close-nav" type="button" aria-label="<?php esc_attr_e( 'Cerrar menú', 'mallorca' ); ?>">
				<?php echo mallorca_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		</div>
		<nav class="mallorca-drawer__nav">
			<?php
			mallorca_nav(
				'mobile',
				array(
					__( 'Tienda', 'mallorca' )            => mallorca_shop_url(),
					__( 'Pastelería', 'mallorca' )        => mallorca_shop_url(),
					__( 'Restaurante', 'mallorca' )       => home_url( '/restaurante/' ),
					__( 'Nuestra historia', 'mallorca' )  => mallorca_historia_url(),
					__( 'Sucursales', 'mallorca' )        => mallorca_locations_url(),
					__( 'Mi cuenta', 'mallorca' )         => mallorca_account_url(),
				)
			);
			?>
		</nav>
	</div>
</div>
