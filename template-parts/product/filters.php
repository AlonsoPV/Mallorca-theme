<?php
/**
 * Shop filters (horizontal / drawer).
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! taxonomy_exists( 'product_cat' ) ) {
	return;
}

$terms    = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true ) );
$current  = isset( $_GET['product_cat'] ) ? sanitize_title( wp_unslash( $_GET['product_cat'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$min      = isset( $_GET['min_price'] ) ? sanitize_text_field( wp_unslash( $_GET['min_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$max      = isset( $_GET['max_price'] ) ? sanitize_text_field( wp_unslash( $_GET['max_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$in_stock = isset( $_GET['in_stock'] ) && '1' === $_GET['in_stock']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$action   = mallorca_shop_url();
?>
<button class="mallorca-btn mallorca-btn--ghost mallorca-filters-toggle js-mallorca-open-filters" type="button"><?php esc_html_e( 'Filtros', 'mallorca' ); ?></button>
<form class="mallorca-filters js-mallorca-filters" method="get" action="<?php echo esc_url( $action ); ?>">
	<div class="mallorca-filters__row">
		<label>
			<span><?php esc_html_e( 'Categoría', 'mallorca' ); ?></span>
			<select name="product_cat">
				<option value=""><?php esc_html_e( 'Todas', 'mallorca' ); ?></option>
				<?php if ( ! is_wp_error( $terms ) ) : ?>
					<?php foreach ( $terms as $term ) : ?>
						<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $current, $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</label>
		<label>
			<span><?php esc_html_e( 'Precio mín.', 'mallorca' ); ?></span>
			<input type="number" name="min_price" min="0" step="1" value="<?php echo esc_attr( $min ); ?>" />
		</label>
		<label>
			<span><?php esc_html_e( 'Precio máx.', 'mallorca' ); ?></span>
			<input type="number" name="max_price" min="0" step="1" value="<?php echo esc_attr( $max ); ?>" />
		</label>
		<label class="mallorca-filters__check">
			<input type="checkbox" name="in_stock" value="1" <?php checked( $in_stock ); ?> />
			<span><?php esc_html_e( 'Disponibles', 'mallorca' ); ?></span>
		</label>
		<button class="mallorca-btn mallorca-btn--solid" type="submit"><?php esc_html_e( 'Aplicar', 'mallorca' ); ?></button>
	</div>
</form>
