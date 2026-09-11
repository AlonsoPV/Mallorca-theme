<?php
/**
 * Site header.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$left_fallback = array(
	__( 'Tienda', 'mallorca' )          => mallorca_shop_url(),
	__( 'Pastelería', 'mallorca' )      => mallorca_shop_url(),
	__( 'Restaurante', 'mallorca' )     => home_url( '/restaurante/' ),
	__( 'Nuestra historia', 'mallorca' ) => mallorca_historia_url(),
);
$right_fallback = array(
	__( 'Sucursales', 'mallorca' ) => mallorca_locations_url(),
);
?>
<header class="mallorca-header js-mallorca-header" role="banner">
	<div class="mallorca-header__inner">
		<button class="mallorca-icon-btn mallorca-header__menu js-mallorca-open-nav" type="button" aria-expanded="false" aria-controls="mallorca-drawer" aria-label="<?php esc_attr_e( 'Abrir menú', 'mallorca' ); ?>">
			<?php echo mallorca_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</button>

		<nav class="mallorca-header__left" aria-label="<?php esc_attr_e( 'Principal izquierda', 'mallorca' ); ?>">
			<?php mallorca_nav( 'primary_left', $left_fallback ); ?>
		</nav>

		<div class="mallorca-header__brand">
			<?php mallorca_the_brand_logo( 'header' ); ?>
		</div>

		<div class="mallorca-header__right">
			<nav class="mallorca-header__links" aria-label="<?php esc_attr_e( 'Principal derecha', 'mallorca' ); ?>">
				<?php mallorca_nav( 'primary_right', $right_fallback ); ?>
			</nav>
			<button class="mallorca-icon-btn js-mallorca-open-search" type="button" aria-expanded="false" aria-controls="mallorca-search" aria-label="<?php esc_attr_e( 'Buscar', 'mallorca' ); ?>">
				<?php echo mallorca_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
			<a class="mallorca-icon-btn mallorca-header__account" href="<?php echo esc_url( mallorca_account_url() ); ?>" aria-label="<?php esc_attr_e( 'Mi cuenta', 'mallorca' ); ?>">
				<?php echo mallorca_icon( 'user' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
			<button class="mallorca-icon-btn mallorca-header__cart js-mallorca-open-cart" type="button" aria-expanded="false" aria-controls="mallorca-mini-cart" aria-label="<?php esc_attr_e( 'Carrito', 'mallorca' ); ?>">
				<?php echo mallorca_icon( 'cart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php mallorca_cart_count_markup(); ?>
			</button>
		</div>
	</div>
</header>
