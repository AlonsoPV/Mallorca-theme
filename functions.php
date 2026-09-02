<?php
/**
 * Mallorca theme bootstrap.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MALLORCA_VERSION', '1.0.0' );
define( 'MALLORCA_DIR', get_template_directory() );
define( 'MALLORCA_URI', get_template_directory_uri() );

require_once MALLORCA_DIR . '/inc/setup.php';
require_once MALLORCA_DIR . '/inc/template-tags.php';
require_once MALLORCA_DIR . '/inc/enqueue.php';
require_once MALLORCA_DIR . '/inc/customizer.php';
require_once MALLORCA_DIR . '/inc/cpt-location.php';
require_once MALLORCA_DIR . '/inc/product-meta.php';
require_once MALLORCA_DIR . '/inc/woocommerce.php';
require_once MALLORCA_DIR . '/inc/checkout-mexico.php';
require_once MALLORCA_DIR . '/inc/elementor/class-mallorca-elementor.php';
require_once MALLORCA_DIR . '/inc/rest.php';
require_once MALLORCA_DIR . '/inc/demo-content.php';
