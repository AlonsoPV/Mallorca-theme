<?php
/**
 * Footer.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$used_builder_footer = ! mallorca_is_store_surface()
	&& function_exists( 'elementor_theme_do_location' )
	&& elementor_theme_do_location( 'footer' );

if ( ! $used_builder_footer ) {
	mallorca_print_footer_chrome();
}

wp_footer();
?>
</body>
</html>
