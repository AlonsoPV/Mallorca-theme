<?php
/**
 * Search overlay.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="mallorca-search" class="mallorca-search" hidden>
	<div class="mallorca-search__panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Buscar', 'mallorca' ); ?>">
		<div class="mallorca-search__top">
			<form class="mallorca-search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
				<label class="screen-reader-text" for="mallorca-search-field"><?php esc_html_e( 'Buscar', 'mallorca' ); ?></label>
				<input id="mallorca-search-field" class="js-mallorca-search-input" type="search" name="s" placeholder="<?php esc_attr_e( 'Buscar pasteles, bollería, pan…', 'mallorca' ); ?>" autocomplete="off" />
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<input type="hidden" name="post_type" value="product" />
				<?php endif; ?>
			</form>
			<button class="mallorca-icon-btn js-mallorca-close-search" type="button" aria-label="<?php esc_attr_e( 'Cerrar búsqueda', 'mallorca' ); ?>">
				<?php echo mallorca_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		</div>
		<div class="mallorca-search__results js-mallorca-search-results" aria-live="polite"></div>
	</div>
</div>
