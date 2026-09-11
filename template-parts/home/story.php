<?php
/**
 * Storytelling split.
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
$kicker   = mallorca_arg( $args, 'kicker', 'story_kicker', $copy['story_kicker'] );
$title    = mallorca_arg( $args, 'title', 'story_title', $copy['story_title'] );
$text     = mallorca_arg( $args, 'text', 'story_text', $copy['story_text'] );
$text_2   = mallorca_arg( $args, 'text_2', 'story_text_2', $copy['story_text_2'] );
$cta      = mallorca_arg( $args, 'cta', 'story_cta', $copy['story_cta'] );
$cta_url  = mallorca_arg( $args, 'cta_url', 'story_cta_url', mallorca_historia_url() );
$image_id = mallorca_arg_image_id( $args, 'image', 'story_image' );
if ( ! $cta_url ) {
	$cta_url = mallorca_historia_url();
}

$facts = array(
	array( '2016', __( 'México', 'mallorca' ) ),
	array( __( 'Cada día', 'mallorca' ), __( 'El horno', 'mallorca' ) ),
	array( __( 'Mesa', 'mallorca' ), __( 'Y sobremesa', 'mallorca' ) ),
);
?>
<section class="mallorca-story mallorca-reveal">
	<div class="mallorca-story__media">
		<?php
		echo mallorca_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$image_id,
			'mallorca-editorial',
			'/assets/images/demo/story-oven.jpg',
			array(
				'alt'   => $title,
				'class' => 'mallorca-story__img',
			)
		);
		?>
	</div>
	<div class="mallorca-story__copy">
		<p class="mallorca-kicker mallorca-kicker--accent"><?php echo esc_html( $kicker ); ?></p>
		<h2><?php echo esc_html( $title ); ?></h2>
		<p><?php echo esc_html( $text ); ?></p>
		<p><?php echo esc_html( $text_2 ); ?></p>
		<div class="mallorca-story__facts">
			<?php foreach ( $facts as $fact ) : ?>
				<div>
					<p class="mallorca-story__fact-n"><?php echo esc_html( $fact[0] ); ?></p>
					<p class="mallorca-story__fact-l"><?php echo esc_html( $fact[1] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
		<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta ); ?> <?php echo mallorca_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
	</div>
</section>
