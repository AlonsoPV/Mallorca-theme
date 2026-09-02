<?php
/**
 * Newsletter.
 *
 * @package Mallorca
 *
 * @var array $args Elementor settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args      = isset( $args ) && is_array( $args ) ? $args : array();
$copy      = mallorca_default_copy();
$title     = mallorca_arg( $args, 'title', 'news_title', $copy['news_title'] );
$text      = mallorca_arg( $args, 'text', 'news_text', $copy['news_text'] );
$cta       = mallorca_arg( $args, 'cta', 'news_cta', $copy['news_cta'] );
$shortcode = mallorca_arg( $args, 'shortcode', 'news_shortcode', '' );
?>
<section class="mallorca-news" id="newsletter">
	<h2><?php echo esc_html( $title ); ?></h2>
	<p><?php echo esc_html( $text ); ?></p>
	<?php if ( $shortcode ) : ?>
		<div class="mallorca-news__form mallorca-news__form--plugin"><?php echo do_shortcode( $shortcode ); ?></div>
	<?php else : ?>
		<form class="mallorca-news__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="mallorca_newsletter" />
			<?php wp_nonce_field( 'mallorca_newsletter', 'mallorca_newsletter_nonce' ); ?>
			<label class="screen-reader-text" for="mallorca-news-email"><?php esc_html_e( 'Correo electrónico', 'mallorca' ); ?></label>
			<input id="mallorca-news-email" type="email" name="email" required placeholder="<?php esc_attr_e( 'Tu correo', 'mallorca' ); ?>" />
			<button class="mallorca-btn mallorca-btn--solid" type="submit"><?php echo esc_html( $cta ); ?></button>
		</form>
		<p class="mallorca-news__hint"><?php esc_html_e( 'Pega el shortcode de Mailchimp, Brevo o Fluent Forms en Apariencia → Personalizar o en el widget de Elementor.', 'mallorca' ); ?></p>
	<?php endif; ?>
</section>
