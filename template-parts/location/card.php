<?php
/**
 * Location card.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$id      = get_the_ID();
$name    = mallorca_location_meta( $id, 'location_name' );
$name    = $name ? $name : get_the_title();
$address = mallorca_location_meta( $id, 'address' );
$phone   = mallorca_location_meta( $id, 'phone' );
$hours   = mallorca_location_meta( $id, 'schedule' );
$maps    = mallorca_location_meta( $id, 'google_maps_url' );
$reserve = mallorca_location_meta( $id, 'reservation_url' );
$order   = mallorca_location_meta( $id, 'order_url' );
$wa      = mallorca_location_meta( $id, 'whatsapp' );
$hours   = $hours ? preg_replace( '/\s*\n+\s*/', ' · ', trim( $hours ) ) : '';
$tel     = $phone ? preg_replace( '/[^\d+]/', '', $phone ) : '';

if ( $order ) {
	$order_url = $order;
} elseif ( $wa ) {
	$order_url = 'https://wa.me/' . preg_replace( '/\D+/', '', $wa );
} else {
	$order_url = mallorca_shop_url();
}
?>
<article class="mallorca-location-card">
	<a class="mallorca-location-card__media" href="<?php the_permalink(); ?>">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'mallorca-editorial' );
		} else {
			echo mallorca_image( 0, 'mallorca-editorial', '/assets/images/demo/location-interior.jpg', array( 'alt' => $name ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</a>
	<div class="mallorca-location-card__body">
		<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( $name ); ?></a></h3>
		<ul class="mallorca-location-card__meta">
			<?php if ( $address ) : ?>
				<li>
					<span class="mallorca-location-card__icon" aria-hidden="true"><?php echo mallorca_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span><?php echo esc_html( $address ); ?></span>
				</li>
			<?php endif; ?>
			<?php if ( $hours ) : ?>
				<li>
					<span class="mallorca-location-card__icon" aria-hidden="true"><?php echo mallorca_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span><?php echo esc_html( $hours ); ?></span>
				</li>
			<?php endif; ?>
			<?php if ( $phone ) : ?>
				<li>
					<span class="mallorca-location-card__icon" aria-hidden="true"><?php echo mallorca_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<a href="<?php echo esc_url( 'tel:' . $tel ); ?>"><?php echo esc_html( $phone ); ?></a>
				</li>
			<?php endif; ?>
		</ul>
		<div class="mallorca-location-card__actions">
			<?php if ( $maps ) : ?>
				<a class="mallorca-btn mallorca-btn--ghost" href="<?php echo esc_url( $maps ); ?>"><?php esc_html_e( 'Cómo llegar', 'mallorca' ); ?></a>
			<?php endif; ?>
			<?php if ( $reserve ) : ?>
				<a class="mallorca-btn mallorca-btn--ghost" href="<?php echo esc_url( $reserve ); ?>"><?php esc_html_e( 'Reservar', 'mallorca' ); ?></a>
			<?php endif; ?>
			<a class="mallorca-btn mallorca-btn--solid" href="<?php echo esc_url( $order_url ); ?>"><?php esc_html_e( 'Pedir', 'mallorca' ); ?></a>
		</div>
	</div>
</article>
