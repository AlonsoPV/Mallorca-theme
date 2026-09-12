<?php
/**
 * Elementor integration: locations, kit, widgets.
 *
 * @package Mallorca
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Boot Elementor layer when the plugin is active.
 */
function mallorca_elementor_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	add_action( 'elementor/elements/categories_registered', 'mallorca_elementor_category' );
	add_action( 'elementor/widgets/register', 'mallorca_elementor_widgets' );
	add_action( 'elementor/theme/register_locations', 'mallorca_elementor_locations' );
	add_action( 'elementor/preview/enqueue_styles', 'mallorca_elementor_preview_styles' );
	add_action( 'elementor/page_templates/canvas/before_content', 'mallorca_elementor_canvas_header' );
	add_action( 'elementor/page_templates/canvas/after_content', 'mallorca_elementor_canvas_footer' );
	add_filter( 'elementor/theme/need_override_location', 'mallorca_elementor_keep_theme_chrome', 20, 2 );
	add_filter( 'template_include', 'mallorca_elementor_prefer_theme_chrome_template', 999 );
}
add_action( 'init', 'mallorca_elementor_init' );

/**
 * Widget category.
 *
 * @param \Elementor\Elements_Manager $elements_manager Manager.
 */
function mallorca_elementor_category( $elements_manager ) {
	$elements_manager->add_category(
		'mallorca',
		array(
			'title' => __( 'Mallorca', 'mallorca' ),
			'icon'  => 'fa fa-coffee',
		)
	);
}

/**
 * Theme Builder locations (Elementor Pro) and free-compatible fallbacks.
 *
 * @param object $elementor_theme_manager Locations manager.
 */
function mallorca_elementor_locations( $elementor_theme_manager ) {
	if ( method_exists( $elementor_theme_manager, 'register_all_core_location' ) ) {
		$elementor_theme_manager->register_all_core_location();
	}
}

/**
 * Register widgets.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Manager.
 */
function mallorca_elementor_widgets( $widgets_manager ) {
	$files = array(
		'class-widget-hero.php',
		'class-widget-categories.php',
		'class-widget-featured.php',
		'class-widget-story.php',
		'class-widget-season.php',
		'class-widget-experience.php',
		'class-widget-locations.php',
		'class-widget-instagram.php',
		'class-widget-newsletter.php',
		'class-widget-cta.php',
		'class-widget-shop.php',
		'class-widget-product.php',
		'class-widget-cart.php',
		'class-widget-checkout.php',
	);

	foreach ( $files as $file ) {
		$path = MALLORCA_DIR . '/inc/elementor/widgets/' . $file;
		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}

	$classes = array(
		'Mallorca_Widget_Hero',
		'Mallorca_Widget_Categories',
		'Mallorca_Widget_Featured',
		'Mallorca_Widget_Story',
		'Mallorca_Widget_Season',
		'Mallorca_Widget_Experience',
		'Mallorca_Widget_Locations',
		'Mallorca_Widget_Instagram',
		'Mallorca_Widget_Newsletter',
		'Mallorca_Widget_Cta',
		'Mallorca_Widget_Shop',
		'Mallorca_Widget_Product',
		'Mallorca_Widget_Cart',
		'Mallorca_Widget_Checkout',
	);

	foreach ( $classes as $class ) {
		if ( class_exists( $class ) ) {
			$widgets_manager->register( new $class() );
		}
	}
}

/**
 * Preview CSS.
 */
function mallorca_elementor_preview_styles() {
	wp_enqueue_style( 'mallorca-elementor' );
}

/**
 * Sync Elementor kit colors once when possible.
 */
function mallorca_sync_elementor_kit() {
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}
	if ( 'montserrat-1' === get_option( 'mallorca_elementor_kit_synced' ) ) {
		return;
	}
	if ( ! isset( \Elementor\Plugin::$instance->kits_manager ) ) {
		return;
	}

	$kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit();
	if ( ! $kit ) {
		return;
	}

	$kit->update_settings(
		array(
			'system_colors' => array(
				array( '_id' => 'primary', 'title' => 'Primary', 'color' => mallorca_mod( 'color_burgundy', '#DC1427' ) ),
				array( '_id' => 'secondary', 'title' => 'Secondary', 'color' => mallorca_mod( 'color_chocolate', '#3D2418' ) ),
				array( '_id' => 'text', 'title' => 'Text', 'color' => mallorca_mod( 'color_ink', '#2B2118' ) ),
				array( '_id' => 'accent', 'title' => 'Accent', 'color' => mallorca_mod( 'color_burgundy', '#DC1427' ) ),
			),
			'system_typography' => array(
				array(
					'_id'            => 'primary',
					'title'          => 'Primary',
					'typography_font_family' => 'Montserrat',
					'typography_font_weight' => '600',
				),
				array(
					'_id'            => 'secondary',
					'title'          => 'Secondary',
					'typography_font_family' => 'Montserrat',
					'typography_font_weight' => '400',
				),
				array(
					'_id'            => 'text',
					'title'          => 'Text',
					'typography_font_family' => 'Montserrat',
					'typography_font_weight' => '400',
				),
				array(
					'_id'            => 'accent',
					'title'          => 'Accent',
					'typography_font_family' => 'Montserrat',
					'typography_font_weight' => '500',
				),
			),
			'body_color'                => mallorca_mod( 'color_ink', '#2B2118' ),
			'body_background_color'     => mallorca_mod( 'color_ivory', '#F6F1E8' ),
			'button_background_color'   => mallorca_mod( 'color_burgundy', '#DC1427' ),
			'button_text_color'         => mallorca_mod( 'color_ivory', '#F6F1E8' ),
			'button_border_radius'      => array(
				'unit'   => 'px',
				'top'    => '0',
				'right'  => '0',
				'bottom' => '0',
				'left'   => '0',
			),
			'container_padding'         => array(
				'unit'   => 'px',
				'top'    => '0',
				'right'  => '0',
				'bottom' => '0',
				'left'   => '0',
				'isLinked' => true,
			),
		)
	);

	update_option( 'mallorca_elementor_kit_synced', 'montserrat-1' );
}
add_action( 'elementor/init', 'mallorca_sync_elementor_kit', 20 );

/**
 * Page templates for Elementor canvas / full width.
 *
 * @param array $templates Templates.
 * @return array
 */
function mallorca_elementor_page_templates( $templates ) {
	$templates['templates/elementor-fullwidth.php'] = __( 'Mallorca / Elementor ancho completo', 'mallorca' );
	$templates['templates/elementor-canvas.php']    = __( 'Mallorca / Elementor canvas', 'mallorca' );
	$templates['templates/template-shop.php']       = __( 'Mallorca / Tienda', 'mallorca' );
	$templates['templates/template-product.php']    = __( 'Mallorca / Producto', 'mallorca' );
	$templates['templates/template-cart.php']       = __( 'Mallorca / Carrito', 'mallorca' );
	$templates['templates/template-checkout.php']   = __( 'Mallorca / Checkout', 'mallorca' );
	return $templates;
}
add_filter( 'theme_page_templates', 'mallorca_elementor_page_templates' );
add_filter( 'theme_post_templates', 'mallorca_elementor_page_templates' );

/**
 * Print an Elementor document.
 *
 * @param int $post_id Post ID.
 */
function mallorca_elementor_content( $post_id ) {
	$post_id = (int) $post_id;
	if ( ! $post_id || ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}
	echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Elementor library assigned as the single product template.
 *
 * @return int
 */
function mallorca_elementor_product_template_id() {
	$id = (int) get_option( 'mallorca_elementor_product_template', 0 );
	if ( $id && get_post( $id ) && mallorca_is_elementor_page( $id ) ) {
		return $id;
	}
	return 0;
}

/**
 * Save Elementor document data on a post.
 *
 * @param int    $post_id Post ID.
 * @param string $widget  Widget name.
 * @param string $type    Elementor template type.
 */
function mallorca_apply_elementor_widget_document( $post_id, $widget, $type = 'wp-page' ) {
	$post_id = (int) $post_id;
	if ( ! $post_id || ! did_action( 'elementor/loaded' ) ) {
		return;
	}
	$data = array( mallorca_elementor_section( $widget, array() ) );
	update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $post_id, '_elementor_template_type', $type );
	update_post_meta( $post_id, '_elementor_version', '3.20.0' );
	update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
	update_post_meta(
		$post_id,
		'_elementor_page_settings',
		array(
			'hide_title' => 'yes',
			'template'   => 'default',
		)
	);
}

/**
 * Keep Mallorca header/footer on store screens even if Theme Builder is active.
 *
 * @param bool   $need_override Whether Elementor should override the location.
 * @param string $location      Location name.
 * @return bool
 */
function mallorca_elementor_keep_theme_chrome( $need_override, $location ) {
	if ( mallorca_is_store_surface() && in_array( $location, array( 'header', 'footer' ), true ) ) {
		return false;
	}
	return $need_override;
}

/**
 * Inject theme header into Elementor's blank canvas template.
 */
function mallorca_elementor_canvas_header() {
	if ( did_action( 'get_header' ) || did_action( 'mallorca_header_chrome' ) ) {
		return;
	}
	if ( ! mallorca_is_store_surface() ) {
		return;
	}
	mallorca_print_header_chrome( true );
}

/**
 * Inject theme footer into Elementor's blank canvas template.
 */
function mallorca_elementor_canvas_footer() {
	if ( did_action( 'get_footer' ) || did_action( 'mallorca_footer_chrome' ) ) {
		return;
	}
	if ( ! mallorca_is_store_surface() ) {
		return;
	}
	mallorca_print_footer_chrome();
}

/**
 * Cart and checkout pages must not use Elementor's blank canvas.
 *
 * @param string $template Template path.
 * @return string
 */
function mallorca_elementor_prefer_theme_chrome_template( $template ) {
	if ( ! function_exists( 'is_cart' ) || ( ! is_cart() && ! is_checkout() ) ) {
		return $template;
	}

	$normalized = strtolower( str_replace( '\\', '/', (string) $template ) );
	if ( ! preg_match( '#/elementor/.+/canvas\.php$#', $normalized ) ) {
		return $template;
	}

	$fullwidth = get_theme_file_path( 'templates/elementor-fullwidth.php' );
	return ( $fullwidth && file_exists( $fullwidth ) ) ? $fullwidth : $template;
}
