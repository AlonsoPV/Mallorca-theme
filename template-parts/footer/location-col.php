<?php
/**
 * Footer location column.
 *
 * @package Mallorca
 *
 * @var array $args { location: array }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$location = isset( $args['location'] ) && is_array( $args['location'] ) ? $args['location'] : array();
if ( ! $location ) {
	return;
}

$heading = isset( $location['heading'] ) ? $location['heading'] : '';
$phone   = isset( $location['phone'] ) ? $location['phone'] : '';
$email   = isset( $location['email'] ) ? $location['email'] : '';
$address = isset( $location['address'] ) ? $location['address'] : '';
$maps    = isset( $location['maps'] ) ? $location['maps'] : '';
$tel     = $phone ? preg_replace( '/[^\d+]/', '', $phone ) : '';
?>
<div class="mallorca-footer__col mallorca-footer__col--store">
	<p class="mallorca-footer__title"><?php echo esc_html( $heading ); ?></p>
	<ul class="mallorca-footer__list mallorca-footer__list--store">
		<?php if ( $phone ) : ?>
			<li>
				<a class="mallorca-footer__link" href="<?php echo esc_url( 'tel:' . $tel ); ?>">
					<span class="mallorca-footer__icon" aria-hidden="true"><?php echo mallorca_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span><?php echo esc_html( $phone ); ?></span>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( $email ) : ?>
			<li>
				<a class="mallorca-footer__link" href="<?php echo esc_url( 'mailto:' . $email ); ?>">
					<span class="mallorca-footer__icon" aria-hidden="true"><?php echo mallorca_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span><?php echo esc_html( $email ); ?></span>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( $address ) : ?>
			<li>
				<?php if ( $maps ) : ?>
					<a class="mallorca-footer__link" href="<?php echo esc_url( $maps ); ?>"<?php echo mallorca_is_external_url( $maps ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
						<span class="mallorca-footer__icon" aria-hidden="true"><?php echo mallorca_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span><?php echo esc_html( $address ); ?></span>
					</a>
				<?php else : ?>
					<span class="mallorca-footer__link">
						<span class="mallorca-footer__icon" aria-hidden="true"><?php echo mallorca_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span><?php echo esc_html( $address ); ?></span>
					</span>
				<?php endif; ?>
			</li>
		<?php endif; ?>
	</ul>
</div>
