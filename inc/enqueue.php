<?php
/**
 * Scripts and styles.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end assets.
 */
function mallorca_enqueue_assets() {
	$css = array(
		'tokens'     => 'tokens.css',
		'base'       => 'base.css',
		'components' => 'components.css',
		'header'     => 'header.css',
		'footer'     => 'footer.css',
		'home'       => 'home.css',
		'historia'   => 'historia.css',
		'shop'       => 'shop.css',
		'product'    => 'product.css',
		'cart'       => 'cart.css',
		'checkout'   => 'checkout.css',
		'account'    => 'account.css',
		'woocommerce'=> 'woocommerce.css',
		'elementor'  => 'elementor.css',
	);

	$deps = array();
	foreach ( $css as $handle => $file ) {
		$path = '/assets/css/' . $file;
		$full = MALLORCA_DIR . $path;
		if ( ! file_exists( $full ) ) {
			continue;
		}
		wp_enqueue_style(
			'mallorca-' . $handle,
			MALLORCA_URI . $path,
			$deps,
			(string) filemtime( $full )
		);
		$deps[] = 'mallorca-' . $handle;
	}

	wp_enqueue_script(
		'mallorca-theme',
		MALLORCA_URI . '/assets/js/theme.js',
		array(),
		(string) filemtime( MALLORCA_DIR . '/assets/js/theme.js' ),
		true
	);

	wp_localize_script(
		'mallorca-theme',
		'mallorcaTheme',
		array(
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'restUrl'      => esc_url_raw( rest_url( 'mallorca/v1/' ) ),
			'nonce'        => wp_create_nonce( 'mallorca_front' ),
			'wcNonce'      => wp_create_nonce( 'wc_store_api' ),
			'cartUrl'      => mallorca_cart_url(),
			'checkoutUrl'  => mallorca_checkout_url(),
			'isWc'         => function_exists( 'WC' ),
			'i18n'         => array(
				'searchPlaceholder' => __( 'Buscar pasteles, bollería, pan…', 'mallorca' ),
				'noResults'         => __( 'No encontramos nada con esa búsqueda.', 'mallorca' ),
				'added'             => __( 'Añadido a tu pedido', 'mallorca' ),
				'selectOptions'     => __( 'Seleccionar opciones', 'mallorca' ),
			),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mallorca_enqueue_assets', 20 );

/**
 * Preload heading font.
 */
function mallorca_preload_fonts() {
	$font = MALLORCA_URI . '/assets/fonts/montserrat-500.woff2';
	echo '<link rel="preload" href="' . esc_url( $font ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
}
add_action( 'wp_head', 'mallorca_preload_fonts', 1 );

/**
 * Inline CSS variables from Customizer.
 */
function mallorca_customizer_css() {
	$ivory     = mallorca_mod( 'color_ivory', '#F6F1E8' );
	$bone      = mallorca_mod( 'color_bone', '#EBE4D8' );
	$cream     = mallorca_mod( 'color_cream', '#F3EDE3' );
	$ink       = mallorca_mod( 'color_ink', '#2B2118' );
	$burgundy  = mallorca_mod( 'color_burgundy', '#DC1427' );
	$chocolate = mallorca_mod( 'color_chocolate', '#3D2418' );
	$olive     = mallorca_mod( 'color_olive', '#5A5840' );
	$sand      = mallorca_mod( 'color_sand', '#C9BBA6' );
	$preset    = mallorca_mod( 'type_preset', 'editorial' );

	$heading = 'Montserrat, "Helvetica Neue", Helvetica, Arial, sans-serif';
	$body    = 'Montserrat, "Helvetica Neue", Helvetica, Arial, sans-serif';

	if ( 'clasica' === $preset ) {
		$heading = 'Georgia, "Times New Roman", serif';
	} elseif ( 'contemporanea' === $preset ) {
		$heading = $body;
	}

	$css  = ':root{';
	$css .= '--color-ivory:' . $ivory . ';';
	$css .= '--color-bone:' . $bone . ';';
	$css .= '--color-cream:' . $cream . ';';
	$css .= '--color-ink:' . $ink . ';';
	$css .= '--color-burgundy:' . $burgundy . ';';
	$css .= '--color-chocolate:' . $chocolate . ';';
	$css .= '--color-olive:' . $olive . ';';
	$css .= '--color-sand:' . $sand . ';';
	$css .= '--font-heading:' . $heading . ';';
	$css .= '--font-body:' . $body . ';';
	$css .= '}';

	wp_add_inline_style( 'mallorca-tokens', $css );
}
add_action( 'wp_enqueue_scripts', 'mallorca_customizer_css', 30 );

/**
 * Body classes.
 *
 * @param array $classes Classes.
 * @return array
 */
function mallorca_body_classes( $classes ) {
	if ( mallorca_is_elementor_page() ) {
		$classes[] = 'mallorca-has-elementor';
	}
	if ( mallorca_is_store_surface() ) {
		$classes[] = 'mallorca-store-surface';
	}
	if ( function_exists( 'is_checkout' ) && is_checkout() && ! is_wc_endpoint_url() ) {
		$classes[] = 'mallorca-checkout-page';
	}
	if ( function_exists( 'is_cart' ) && is_cart() ) {
		$classes[] = 'mallorca-cart-page';
	}
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		$classes[] = 'mallorca-shop-page';
	}
	if ( function_exists( 'is_product' ) && is_product() ) {
		$classes[] = 'mallorca-product-page';
	}
	return $classes;
}
add_filter( 'body_class', 'mallorca_body_classes' );
