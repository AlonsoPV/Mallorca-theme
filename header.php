<?php
/**
 * Header.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Saltar al contenido', 'mallorca' ); ?></a>
<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	get_template_part( 'template-parts/header/site-header' );
}
get_template_part( 'template-parts/header/mobile-drawer' );
get_template_part( 'template-parts/search/overlay' );
get_template_part( 'template-parts/header/mini-cart' );
echo '<div class="mallorca-toast js-mallorca-toast" hidden role="status"></div>';
