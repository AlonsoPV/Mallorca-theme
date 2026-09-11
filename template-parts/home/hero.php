<?php
/**
 * Home hero.
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
$kicker   = mallorca_arg( $args, 'kicker', 'hero_kicker', $copy['hero_kicker'] );
$title    = mallorca_arg( $args, 'title', 'hero_title', $copy['hero_title'] );
$subtitle = mallorca_arg( $args, 'subtitle', 'hero_subtitle', $copy['hero_subtitle'] );
$cta      = mallorca_arg( $args, 'cta', 'hero_cta', $copy['hero_cta'] );
$cta2     = mallorca_arg( $args, 'cta2', 'hero_cta2', $copy['hero_cta2'] );
$cta_url  = mallorca_arg( $args, 'cta_url', 'hero_cta_url', mallorca_shop_url() );
$cta2_url = mallorca_arg( $args, 'cta2_url', 'hero_cta2_url', mallorca_shop_url() );
$image_id = mallorca_arg_image_id( $args, 'image', 'hero_image' );
if ( ! $cta_url ) {
	$cta_url = mallorca_shop_url();
}
if ( ! $cta2_url ) {
	$cta2_url = mallorca_shop_url();
}
?>
<section class="mallorca-hero">
	<div class="mallorca-hero__media">
		<?php
		echo mallorca_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$image_id,
			'mallorca-hero',
			'/assets/images/demo/hero.jpg',
			array(
				'alt'           => $kicker,
				'class'         => 'mallorca-hero__img',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
	</div>
	<div class="mallorca-hero__copy">
		<p class="mallorca-kicker"><?php echo esc_html( $kicker ); ?></p>
		<h1><?php echo esc_html( $title ); ?><br /><?php echo esc_html( $subtitle ); ?></h1>
		<div class="mallorca-hero__actions">
			<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta ); ?></a>
			<a class="mallorca-btn mallorca-btn--light" href="<?php echo esc_url( $cta2_url ); ?>"><?php echo esc_html( $cta2 ); ?></a>
		</div>
	</div>
</section>
