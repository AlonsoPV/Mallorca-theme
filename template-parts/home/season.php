<?php
/**
 * Seasonal collection banner.
 *
 * @package Mallorca
 *
 * @var array $args Elementor settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args     = isset( $args ) && is_array( $args ) ? $args : array();
$copy     = mallorca_default_copy();
$kicker   = mallorca_arg( $args, 'kicker', 'season_kicker', $copy['season_kicker'] );
$title    = mallorca_arg( $args, 'title', 'season_title', $copy['season_title'] );
$text     = mallorca_arg( $args, 'text', 'season_text', $copy['season_text'] );
$cta      = mallorca_arg( $args, 'cta', 'season_cta', $copy['season_cta'] );
$cta_url  = mallorca_arg( $args, 'cta_url', 'season_cta_url', '' );
$image_id = mallorca_arg_image_id( $args, 'image', 'season_image' );
$cat_id   = (int) mallorca_mod( 'season_category', 0 );

if ( ! $cta_url && $cat_id && taxonomy_exists( 'product_cat' ) ) {
	$term = get_term( $cat_id, 'product_cat' );
	if ( $term && ! is_wp_error( $term ) ) {
		$cta_url = get_term_link( $term );
	}
}
if ( ! $cta_url ) {
	$cta_url = mallorca_shop_url();
}
?>
<section class="mallorca-season mallorca-reveal">
	<div class="mallorca-season__media">
		<?php
		echo mallorca_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$image_id,
			'mallorca-hero',
			'/assets/images/demo/product-frutos.jpg',
			array(
				'alt'   => $title,
				'class' => 'mallorca-season__img',
			)
		);
		?>
	</div>
	<div class="mallorca-season__copy">
		<p class="mallorca-kicker mallorca-kicker--light"><?php echo esc_html( $kicker ); ?></p>
		<h2><?php echo esc_html( $title ); ?></h2>
		<p><?php echo esc_html( $text ); ?></p>
		<a class="mallorca-btn mallorca-btn--light" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta ); ?></a>
	</div>
</section>
