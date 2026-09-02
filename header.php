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
<?php
$used_builder_header = ! mallorca_is_store_surface()
	&& function_exists( 'elementor_theme_do_location' )
	&& elementor_theme_do_location( 'header' );

if ( $used_builder_header ) {
	echo '<a class="skip-link screen-reader-text" href="#primary">' . esc_html__( 'Saltar al contenido', 'mallorca' ) . '</a>';
	get_template_part( 'template-parts/header/mobile-drawer' );
	get_template_part( 'template-parts/search/overlay' );
	get_template_part( 'template-parts/header/mini-cart' );
	echo '<div class="mallorca-toast js-mallorca-toast" hidden role="status"></div>';
	do_action( 'mallorca_header_chrome' );
} else {
	mallorca_print_header_chrome( true );
}
