<?php
/**
 * Footer.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	get_template_part( 'template-parts/footer/site-footer' );
}
wp_footer();
?>
</body>
</html>
