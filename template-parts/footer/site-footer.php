<?php
/**
 * Site footer.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$comments_url = mallorca_mod( 'footer_comments_url' );
$discover     = mallorca_footer_discover_links();
$locations    = mallorca_footer_selected_locations();
?>
<footer class="mallorca-footer" role="contentinfo">
	<div class="mallorca-footer__inner">
		<div class="mallorca-footer__grid">
			<div class="mallorca-footer__brand">
				<div class="mallorca-footer__logo">
					<?php mallorca_the_brand_logo( 'footer' ); ?>
				</div>
				<?php if ( $comments_url ) : ?>
					<a class="mallorca-footer__comment" href="<?php echo esc_url( $comments_url ); ?>">
						<span class="mallorca-footer__icon" aria-hidden="true"><?php echo mallorca_icon( 'comment' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span><?php esc_html_e( 'Déjanos tus comentarios', 'mallorca' ); ?></span>
					</a>
				<?php endif; ?>
			</div>

			<div class="mallorca-footer__col">
				<p class="mallorca-footer__title"><?php esc_html_e( 'Conoce más', 'mallorca' ); ?></p>
				<?php if ( $discover ) : ?>
					<ul class="mallorca-footer__list">
						<?php foreach ( $discover as $item ) : ?>
							<li>
								<a class="mallorca-footer__link mallorca-footer__link--center" href="<?php echo esc_url( $item['url'] ); ?>"<?php echo mallorca_is_external_url( $item['url'] ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
									<span class="mallorca-footer__icon" aria-hidden="true"><?php echo mallorca_icon( $item['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									<span><?php echo esc_html( $item['label'] ); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php
			foreach ( $locations as $location ) {
				get_template_part( 'template-parts/footer/location-col', null, array( 'location' => $location ) );
			}
			?>
		</div>

		<div class="mallorca-footer__bottom">
			<p class="mallorca-footer__copy">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'Pastelería Mallorca', 'mallorca' ); ?></p>
			<nav class="mallorca-footer__legal" aria-label="<?php esc_attr_e( 'Legal', 'mallorca' ); ?>">
				<?php
				mallorca_nav(
					'footer_legal',
					array(
						__( 'Aviso de privacidad', 'mallorca' )     => mallorca_page_url( 'aviso-de-privacidad', home_url( '/aviso-de-privacidad/' ) ),
						__( 'Términos y condiciones', 'mallorca' ) => mallorca_page_url( 'terminos', home_url( '/terminos/' ) ),
					)
				);
				?>
			</nav>
		</div>
	</div>
</footer>
