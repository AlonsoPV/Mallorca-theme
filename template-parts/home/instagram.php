<?php
/**
 * Instagram / social proof grid.
 *
 * @package Mallorca
 *
 * @var array $args Elementor settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args      = isset( $args ) && is_array( $args ) ? $args : array();
$title     = mallorca_arg( $args, 'title', 'ig_title', mallorca_default_copy()['ig_title'] );
$shortcode = mallorca_arg( $args, 'shortcode', 'ig_shortcode', '' );
$gallery   = isset( $args['gallery'] ) && is_array( $args['gallery'] ) ? $args['gallery'] : array();
$ig_url    = mallorca_mod( 'instagram_url', '' );
$fallback  = array( 'product-ensaimada.jpg', 'product-croissant.jpg', 'product-santiago.jpg', 'experience-cafe.jpg', 'product-palmera.jpg', 'product-caja.jpg' );
?>
<section class="mallorca-ig">
	<div class="mallorca-section-head">
		<h2><?php echo esc_html( $title ); ?></h2>
		<?php if ( $ig_url ) : ?>
			<a class="mallorca-btn mallorca-btn--text" href="<?php echo esc_url( $ig_url ); ?>">Instagram</a>
		<?php endif; ?>
	</div>
	<?php if ( $shortcode ) : ?>
		<div class="mallorca-ig__plugin"><?php echo do_shortcode( $shortcode ); ?></div>
	<?php else : ?>
		<div class="mallorca-ig__grid">
			<?php
			if ( $gallery ) {
				foreach ( $gallery as $item ) {
					$id = isset( $item['id'] ) ? (int) $item['id'] : 0;
					echo '<figure>' . mallorca_image( $id, 'mallorca-square', '', array( 'alt' => '' ) ) . '</figure>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			} else {
				$has_custom = false;
				for ( $i = 1; $i <= 6; $i++ ) {
					$id = (int) mallorca_mod( 'ig_image_' . $i, 0 );
					if ( $id ) {
						$has_custom = true;
						echo '<figure>' . mallorca_image( $id, 'mallorca-square', '', array( 'alt' => '' ) ) . '</figure>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
				}
				if ( ! $has_custom ) {
					foreach ( $fallback as $file ) {
						echo '<figure>' . mallorca_image( 0, 'mallorca-square', '/assets/images/demo/' . $file, array( 'alt' => '' ) ) . '</figure>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
				}
			}
			?>
		</div>
	<?php endif; ?>
</section>
