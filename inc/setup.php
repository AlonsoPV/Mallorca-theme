<?php
/**
 * Theme setup.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports, menus and image sizes.
 */
function mallorca_setup() {
	load_theme_textdomain( 'mallorca', MALLORCA_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 280,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_editor_style( 'assets/css/editor.css' );

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary_left'  => __( 'Navegación izquierda', 'mallorca' ),
			'primary_right' => __( 'Navegación derecha', 'mallorca' ),
			'mobile'        => __( 'Menú móvil', 'mallorca' ),
			'footer_brand'  => __( 'Footer Mallorca', 'mallorca' ),
			'footer_shop'   => __( 'Footer Tienda', 'mallorca' ),
			'footer_stores' => __( 'Footer Sucursales', 'mallorca' ),
			'footer_help'   => __( 'Footer Atención', 'mallorca' ),
			'footer_legal'  => __( 'Footer Legal', 'mallorca' ),
		)
	);

	add_image_size( 'mallorca-hero', 1920, 1200, true );
	add_image_size( 'mallorca-card', 800, 1000, true );
	add_image_size( 'mallorca-square', 900, 900, true );
	add_image_size( 'mallorca-editorial', 1400, 900, true );

	register_block_pattern_category(
		'mallorca',
		array( 'label' => __( 'Mallorca', 'mallorca' ) )
	);
}
add_action( 'after_setup_theme', 'mallorca_setup' );

/**
 * Promote the previous burgundy default to the Mallorca red accent.
 */
function mallorca_migrate_accent_color() {
	$saved = get_theme_mod( 'mallorca_color_burgundy' );
	if ( is_string( $saved ) && 0 === strcasecmp( $saved, '#6E2433' ) ) {
		set_theme_mod( 'mallorca_color_burgundy', '#DC1427' );
	}
}
add_action( 'after_setup_theme', 'mallorca_migrate_accent_color', 20 );

/**
 * Content width.
 */
function mallorca_content_width() {
	$GLOBALS['content_width'] = 1280;
}
add_action( 'after_setup_theme', 'mallorca_content_width', 0 );

/**
 * Register widget areas used by footer and Elementor.
 */
function mallorca_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer extra', 'mallorca' ),
			'id'            => 'footer-extra',
			'description'   => __( 'Área opcional bajo el pie de página.', 'mallorca' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="widget-title">',
			'after_title'   => '</p>',
		)
	);
}
add_action( 'widgets_init', 'mallorca_widgets_init' );

/**
 * Excerpt length for product cards.
 *
 * @param int $length Length.
 * @return int
 */
function mallorca_excerpt_length( $length ) {
	return 18;
}
add_filter( 'excerpt_length', 'mallorca_excerpt_length' );

/**
 * Excerpt more.
 *
 * @return string
 */
function mallorca_excerpt_more() {
	return '…';
}
add_filter( 'excerpt_more', 'mallorca_excerpt_more' );

/**
 * Basic Open Graph tags when no SEO plugin is present.
 */
function mallorca_open_graph() {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' ) ) {
		return;
	}

	if ( ! is_singular() && ! is_front_page() ) {
		return;
	}

	$title = wp_get_document_title();
	$url   = is_singular() ? get_permalink() : home_url( '/' );
	$desc  = get_bloginfo( 'description', 'display' );
	$image = '';

	if ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( get_the_ID(), 'mallorca-editorial' );
		$excerpt = get_the_excerpt();
		if ( $excerpt ) {
			$desc = wp_strip_all_tags( $excerpt );
		}
	} else {
		$hero = (int) get_theme_mod( 'mallorca_hero_image' );
		if ( $hero ) {
			$image = wp_get_attachment_image_url( $hero, 'mallorca-hero' );
		}
	}

	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '" />' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( is_singular( 'product' ) ? 'product' : 'website' ) . '" />' . "\n";
	if ( $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'mallorca_open_graph', 5 );
